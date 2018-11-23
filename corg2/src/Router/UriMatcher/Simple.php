<?php

declare(strict_types=1);

namespace D630\Corg\Router\UriMatcher;

class Simple implements UriMatcherInterface
{
    private $routeUri;

    public function __construct(string $routeUri)
    {
        $this->routeUri = $routeUri;
    }

    public function getParameters(): array
    {
        return [];
    }

    public function matches(string $requestUri): bool
    {
        return mb_strtolower($this->routeUri) === mb_strtolower($requestUri);
    }
}
