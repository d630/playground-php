<?php

declare(strict_types=1);

namespace D630\Corg\Controller\Dashboard\Response;

use D630\Corg\Response\JsonResponse as PJsonResponse;

class JsonResponse extends PJsonResponse implements JsonResponseInterface
{
    private const HEADER_ALLOW = 'Allow: ';

    public function __construct(array $models, array $settings, array $options)
    {
        // parent::__construct(__NAMESPACE__, $models, $settings, $options);
    }

    public function connect(): void
    {
        header(self::HEADER_ALLOW);
        parent::connect();
    }

    public function delete(): void
    {
        header(self::HEADER_ALLOW);
        parent::delete();
    }

    public function get(): void
    {
        header(self::HEADER_ALLOW);
        parent::get();
    }

    public function head(): void
    {
        header(self::HEADER_ALLOW);
        parent::head();
    }

    public function options(): void
    {
        header(self::HEADER_ALLOW);
        parent::options();
    }

    public function post(): void
    {
        header(self::HEADER_ALLOW);
        parent::post();
    }

    public function put(): void
    {
        header(self::HEADER_ALLOW);
        parent::put();
    }

    public function trace(): void
    {
        header(self::HEADER_ALLOW);
        parent::trace();
    }
}
