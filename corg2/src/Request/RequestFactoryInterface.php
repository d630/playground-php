<?php

declare(strict_types=1);

namespace D630\Corg\Request;

interface RequestFactoryInterface
{
    public function createStandardRequest(string $ns);
}
