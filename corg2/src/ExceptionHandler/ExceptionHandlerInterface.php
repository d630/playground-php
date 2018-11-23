<?php

declare(strict_types=1);

namespace D630\Corg\ExceptionHandler;

interface ExceptionHandlerInterface
{
    public function respond(
        ?string $msg,
        int $code = 500,
        bool $respondMsg = false
    ): void;
}
