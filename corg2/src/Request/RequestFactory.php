<?php

declare(strict_types=1);

namespace D630\Corg\Request;

class RequestFactory
{
    public function createStandardRequest(string $ns)
    {
        $m = $ns . '\\StandardRequest';
        return new $m();
    }
}
