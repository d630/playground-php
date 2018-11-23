<?php

declare(strict_types=1);

namespace D630\Corg\ExceptionHandler;

use D630\Corg\Config;

class ExceptionHandler
{
    private $response;

    public function __construct(?string $http_accept = '')
    {
        $createExceptionHandlerString = 'create'
            . $this->parseMimeType($http_accept)
            . 'ExceptionHandler';
        $this->response = (new ExceptionHandlerFactory())
            ->{$createExceptionHandlerString}();
    }

    public function except(\Throwable $e): void
    {
        error_log(
            sprintf(
                "%s:%d %s (%d) [%s] {{{\n%s\n}}}",
                $e->getFile(),
                $e->getLine(),
                $e->getMessage(),
                $e->getCode(),
                \get_class($e),
                $e->getTraceAsString()
            )
        );

        header('Expires: ' . Config::UNIX_TIME);

        if (method_exists($e, 'getRespondMesg')) {
            $this
                ->response
                ->respond($e->getMessage(), (int) $e->getCode(), $e->getRespondMesg());
        } else {
            $this
                ->response
                ->respond(null, (int) $e->getCode(), false);
        }

        exit(1);
    }

    public function register(): void
    {
        set_exception_handler([$this, 'except']);
    }

    private function parseMimeType(?string $mimeType): string
    {
        $this->configMime = Config::get('mime');

        if (!empty($mimeType)) {
            foreach (explode(',', $mimeType) as $v) {
                $m = strtok($v, ';');
                if (!empty($this->configMime['map'][$m])) {
                    return $this->configMime['map'][$m];
                }
            }
        }

        return $this->configMime['map']['text/plain'];
    }
}
