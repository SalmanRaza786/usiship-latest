<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class NormalizeJsonNumbers
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $data = $response->getData(true);

            $normalize = function ($v) use (&$normalize) {
                if (is_array($v)) {
                    foreach ($v as $k => $val) {
                        $v[$k] = $normalize($val);
                    }
                    return $v;
                }
                if (is_string($v) && is_numeric($v) && !preg_match('/^0\d+$/', $v)) {
                    return ctype_digit((string) $v) ? (int) $v : (float) $v;
                }
                return $v;
            };

            $response->setData($normalize($data));
        }

        return $response;
    }
}
