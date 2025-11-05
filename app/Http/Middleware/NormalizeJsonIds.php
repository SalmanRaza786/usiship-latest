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

        // only numeric strings like "123"
        if (!is_string($value) || !ctype_digit($value)) {
            return $value;
        }

        // keep "00123" style codes
        if ($this->hasLeadingZero($value)) {
            return $value;
        }

        // ➜ NEVER cast *_code or *_by
        if ($this->neverCastKey($parentKey)) {
            return $value;
        }

        // ➜ cast only id / *_id
        if ($this->looksLikeIdKey($parentKey) && $this->fitsPhpInt($value)) {
            return (int) $value;
        }

        return $value;
    }

    private function looksLikeIdKey(?string $key): bool
    {
        if ($key === null) return false;
        return $key === 'id' || str_ends_with($key, '_id');
    }

    private function neverCastKey(?string $key): bool
    {
        if ($key === null) return false;
        // your request: block *_code and *_by from casting
        if (str_ends_with($key, '_code')) return true;
        if (str_ends_with($key, '_by')) return true;

        // keep vehicle_no style fields safe as well (optional but sensible)
        if ($key === 'vehicle_no' || str_ends_with($key, '_no')) return true;

        return false;
    }

    private function hasLeadingZero(string $s): bool
    {
        return strlen($s) > 1 && $s[0] === '0';
    }

    private function fitsPhpInt(string $s): bool
    {
        if (PHP_INT_SIZE < 8) return false; // don't cast on 32-bit PHP
        $max = '9223372036854775807';
        $len = strlen($s);
        if ($len < strlen($max)) return true;
        if ($len > strlen($max)) return false;
        return $s <= $max;
    }
}
