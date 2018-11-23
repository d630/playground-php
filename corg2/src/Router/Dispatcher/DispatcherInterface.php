<?php

declare(strict_types=1);

namespace D630\Corg\Router\Dispatcher;

interface DispatcherInterface
{
    public function dispatch(array $options = []): void;
}
