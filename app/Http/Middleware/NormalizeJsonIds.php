<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class NormalizeJsonIds
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $data = $response->getData(true);
            $response->setData($this->normalize($data));
        }

        return $response;
    }

    private function normalize($value, $parentKey = null)
    {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->normalize($v, is_string($k) ? $k : $parentKey);
            }
            return $value;
        }

        // Only numeric strings like "123"
        if (!is_string($value) || !ctype_digit($value)) {
            return $value;
        }

        // Keep strings like "00123" (leading zeros)
        if ($this->hasLeadingZero($value)) {
            return $value;
        }

        // Cast if key looks like an integer field
        if ($this->looksLikeIntKey($parentKey) && $this->fitsPhpInt($value)) {
            return (int) $value;
        }

        return $value;
    }

    private function looksLikeIntKey(?string $key): bool
    {
        if ($key === null) return false;

        // ✅ These keys should be treated as integers
        return (
            $key === 'id' ||
            str_ends_with($key, '_id') ||
            str_ends_with($key, '_code') ||
            str_ends_with($key, '_by') ||
            str_ends_with($key, 'on') ||
            str_ends_with($key, 'Id')
        );
    }

    private function hasLeadingZero(string $s): bool
    {
        return strlen($s) > 1 && $s[0] === '0';
    }

    private function fitsPhpInt(string $s): bool
    {
        if (PHP_INT_SIZE < 8) return false; // skip casting on 32-bit PHP
        $max = '9223372036854775807';
        $len = strlen($s);
        if ($len < strlen($max)) return true;
        if ($len > strlen($max)) return false;
        return $s <= $max;
    }
}
