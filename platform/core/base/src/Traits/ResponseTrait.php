<?php

namespace TCore\Base\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

trait ResponseTrait
{
    public static function responseAjax(bool $error = false, string $msg = null, $data = null, $statusCode = 200): JsonResponse
    {
        return response()->ajax($error, $msg, $data, $statusCode);
    }

    public static function responseBack(bool $error = false, string $msg = null, bool $withInput = false): RedirectResponse
    {
        $res = back();

        if($withInput)
        {
            $res = $res->withInput();
        }

        return $res->with(...array_values(self::handleType($error, $msg)));
    }

    public static function toRoute(string $name, array|int|string $params = null, bool $error = false, string $msg = null): RedirectResponse
    {
        return to_route($name, $params)->with(...array_values(self::handleType($error, $msg)));
    }

    public static function handleType(bool $error = false, string $msg = null): array
    {
        return [
            'type' => $error ? 'error' : 'success', 
            'msg' => $msg ?: ($error ? trans('notifyFail') : trans('notifySuccess'))
        ];
    }
}