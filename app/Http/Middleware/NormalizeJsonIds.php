<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class NormalizeJsonIds
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Only touch JSON responses
        if ($response instanceof JsonResponse) {
            $data = $response->getData(true);
            $response->setData($this->normalize($data));
        }

        return $response;
    }

    private function normalize($value, $parentKey = null)
    {
        // Recurse arrays (works for nested arrays & collections converted to arrays)
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->normalize($v, is_string($k) ? $k : $parentKey);
            }
            return $value;
        }

        // Only consider numeric strings
        if (!is_string($value) || !ctype_digit($value)) {
            return $value;
        }

        // Preserve leading-zero codes (e.g. "00123")
        if ($this->hasLeadingZero($value)) {
            return $value;
        }

        // Cast only if the key looks like an integer ID
        if ($this->looksLikeIdKey($parentKey) && $this->fitsPhpInt($value)) {
            return (int) $value;
        }

        // Otherwise leave as string (e.g. vehicle_no, *_no, *_code)
        return $value;
    }

    private function looksLikeIdKey(?string $key): bool
    {
        if ($key === null) return false;
        // allowlist: exact "id" or any "*_id"
        return $key === 'id' || str_ends_with($key, '_id');
    }

    private function hasLeadingZero(string $s): bool
    {
        return strlen($s) > 1 && $s[0] === '0';
    }

    private function fitsPhpInt(string $s): bool
    {
        // Safe check without bcmath: compare string length/value to PHP 64-bit max
        // Works on 64-bit PHP. If you're on 32-bit, ints are too small anyway.
        if (PHP_INT_SIZE < 8) return false; // don't cast on 32-bit

        // max for signed 64-bit
        $max = '9223372036854775807';
        $len = strlen($s);
        if ($len < strlen($max)) return true;
        if ($len > strlen($max)) return false;
        return $s <= $max; // string compare works for equal length digit strings
    }
}
