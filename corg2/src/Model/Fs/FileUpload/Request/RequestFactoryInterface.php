<?php

declare(strict_types=1);

namespace D630\Corg\Model\Fs\FileUpload\Request;

use D630\Corg\Request\RequestFactoryInterface as PRequestFactoryInterface;

interface RequestFactoryInterface extends PRequestFactoryInterface
{
    public function createDashboardRequest(string $ns);

    public function createFetchRequest(string $ns);
}
