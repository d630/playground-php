<?php

declare(strict_types=1);

namespace D630\Corg\ExceptionHandler;

class ExceptionHandlerFactory
{
    public function createHtmlExceptionHandler(): ExceptionHandlerInterface
    {
        return new HtmlExceptionHandler();
    }

    public function createJsonExceptionHandler(): ExceptionHandlerInterface
    {
        return new JsonExceptionHandler();
    }

    public function createPlainExceptionHandler(): ExceptionHandlerInterface
    {
        return new PlainExceptionHandler();
    }

    public function createVcardExceptionHandler(): ExceptionHandlerInterface
    {
        return new VcardExceptionHandler();
    }
}
