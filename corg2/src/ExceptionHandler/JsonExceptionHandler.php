<?php

declare(strict_types=1);

namespace D630\Corg\ExceptionHandler;

use D630\Corg\Config;

class JsonExceptionHandler implements ExceptionHandlerInterface
{
    protected $configResponse;

    public function __construct()
    {
        $this->configResponse = Config::get('response');
    }

    public function respond(
        ?string $msg,
        int $code = 500,
        bool $respondMsg = false
    ): void {
        $func = $this->configResponse['status'][$code] ?? @$this->configResponse['status'][500];
        $func();

        header('Content-Type: application/json; charset=UTF-8');

        if ($respondMsg) {
            echo json_encode($msg,
                \JSON_PRESERVE_ZERO_FRACTION |
                \JSON_UNESCAPED_UNICODE |
                \JSON_UNESCAPED_SLASHES
            );
        }
    }
}
