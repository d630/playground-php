<?php

declare(strict_types=1);

namespace D630\Corg\Controller\File\Response;

use D630\Corg\Response\ResponseFactory as PResponseFactory;

class ResponseFactory extends PResponseFactory implements ResponseFactoryInterface
{
    public function createHtmlResponse(
        string $ns,
        array $models,
        array $settings,
        array $options
    ) {
        $m = $ns . '\\HtmlResponse';
        return new $m($models, $settings, $options);
    }
}
