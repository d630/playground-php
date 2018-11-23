<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Auth\Request;

use D630\Corg\Request\StandardRequestInterface as PStandardRequestInterface;

interface StandardRequestInterface extends PStandardRequestInterface
{
    public function getEmployee(?string $nickname, ?string $entityType): array;

    public function setEmployee(?string $nickname, ?string $password): void;
}
