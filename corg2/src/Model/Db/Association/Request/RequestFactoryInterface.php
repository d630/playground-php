<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Association\Request;

use D630\Corg\Request\RequestFactoryInterface as PRequestFactoryInterface;

interface RequestFactoryInterface extends PRequestFactoryInterface
{
    public function createFetchRequest(string $ns);
}
