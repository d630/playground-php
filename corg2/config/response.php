<?php

declare(strict_types=1);

return [
    'status' => [
        200 => static function (): void {
            header('HTTP/1.1 200 OK', true, 200);
        },
        201 => static function (): void {
            header('HTTP/1.1 201 Created', true, 201);
        },
        204 => static function (): void {
            header('HTTP/1.1 204 No Content', true, 204);
        },
        400 => static function (): void {
            header('HTTP/1.1 400 Bad Request', true, 400);
        },
        401 => static function (): void {
            header('HTTP/1.1 401 Unauthorized', true, 401);
        },
        403 => static function (): void {
            header('HTTP/1.1 403 Forbidden', true, 403);
        },
        404 => static function (): void {
            header('HTTP/1.1 404 Not Found', true, 404);
        },
        405 => static function (): void {
            header('HTTP/1.1 405 Method Not Allowed', true, 405);
        },
        406 => static function (): void {
            header('HTTP/1.1 406 Not Acceptable', true, 406);
        },
        415 => static function (): void {
            header('HTTP/1.1 415 Unsupported Media Type', true, 415);
        },
        422 => static function (): void {
            header('HTTP/1.1 422 Unprocessable Entity', true, 422);
        },
        500 => static function (): void {
            header('HTTP/1.1 500 Internal Server Error', true, 500);
        },
    ],
];
