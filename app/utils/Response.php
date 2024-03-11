<?php

namespace App\utils;

use JetBrains\PhpStorm\ArrayShape;

final class Response
{
    #[ArrayShape(['message' => "string"])] public static function internalErr(string $msg="Internal Server Error"): array
    {
        http_response_code(500);
        return ['message' => $msg];
    }
    public static function notFoundErr(): bool|int
    {

        header("Content-Type: application/json; charset=utf-8");
        return http_response_code(404);
    }
}