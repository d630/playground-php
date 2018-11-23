<?php

declare(strict_types=1);

namespace D630\Corg\Router\UriMatcher;

interface UriMatcherInterface
{
    public function getParameters(): array;

    public function matches(string $string): bool;
}
