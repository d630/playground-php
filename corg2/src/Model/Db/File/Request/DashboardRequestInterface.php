<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\File\Request;

interface DashboardRequestInterface extends StandardRequestInterface
{
    public function getAllFiles(): array;
}
