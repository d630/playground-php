<?php

declare(strict_types=1);

namespace D630\Corg\Response;

class ResponseFactory
{
    public function createJsonResponse(
        string $ns,
        array $models,
        array $settings,
        array $options
    ): ResponseInterface {
        $m = $ns . '\\JsonResponse';
        return new $m($models, $settings, $options);
    }
}
