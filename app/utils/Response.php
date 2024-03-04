<?php

namespace App\utils;

use JetBrains\PhpStorm\ArrayShape;

class Response
{
    #[ArrayShape(['message' => "string"])] public static function internalErr(string $msg="Internal Server Error"): array
    {
        http_response_code(500);
        return ['message' => $msg];
    }
}