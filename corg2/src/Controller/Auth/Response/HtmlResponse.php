<?php

declare(strict_types=1);

namespace D630\Corg\Controller\Auth\Response;

use D630\Corg\Response\HtmlResponse as PHtmlResponse;

class HtmlResponse extends PHtmlResponse implements HtmlResponseInterface
{
    public function __construct(array $models, array $settings, array $options)
    {
        parent::__construct(__NAMESPACE__, $models, $settings, $options);
    }
}
