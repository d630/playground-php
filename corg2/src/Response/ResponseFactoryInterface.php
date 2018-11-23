<?php

declare(strict_types=1);

namespace D630\Corg\Response;

interface ResponseFactoryInterface
{
    public function createJsonResponse(
        string $ns,
        array $models,
        array $settings,
        array $options
    ): ResponseInterface;
}
