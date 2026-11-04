<?php

class JsonResponse
{
    public static function response(bool $success, string $message, mixed $data): string
    {
        return json_encode(
            [
                'success' => $success,
                'message' => $message,
                'data'    => $data,
            ],
            JSON_UNESCAPED_UNICODE
        );
    }
}
