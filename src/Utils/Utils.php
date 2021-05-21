<?php

namespace App\Utils;

class Utils
{
    public static function httpResponse( string $url, int $status, $data )
    {
        return [
            "url" => $url,
            "status" => $status,
            "data" => $data
        ];
    }

    public static function errorResponse(string $url, int $status, string $errorMessage)
    {
        return [
            "url" => $url,
            "status" => $status,
            "error" => $errorMessage
        ];
    }
}