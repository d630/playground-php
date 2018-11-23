<?php

declare(strict_types=1);

namespace D630\Corg\Controller\Customer\Response;

use D630\Corg\Response\ResponseFactoryInterface as PResponseFactoryInterface;

interface ResponseFactoryInterface extends PResponseFactoryInterface
{
    public function createHtmlResponse(
        string $ns,
        array $models,
        array $settings,
        array $options
    );

    public function createVcardResponse(
        string $ns,
        array $models,
        array $settings,
        array $options
    );
}
