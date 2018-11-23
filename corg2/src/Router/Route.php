<?php

declare(strict_types=1);

namespace D630\Corg\Router;

use D630\Corg\Router\Dispatcher\DispatcherInterface;
use D630\Corg\Router\UriMatcher\UriMatcherInterface;

class Route
{
    private $dispatcher;
    private $uriMatcher;

    public function __construct(UriMatcherInterface $uriMatcher, DispatcherInterface $dispatcher)
    {
        $this->uriMatcher = $uriMatcher;
        $this->dispatcher = $dispatcher;
    }

    public function dispatch(): void
    {
        $this->dispatcher->dispatch($this->uriMatcher->getParameters());
    }

    public function matches(string $requestUri): bool
    {
        return $this->uriMatcher->matches($requestUri);
    }
}
