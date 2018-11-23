<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Association\Request;

interface FetchRequestInterface extends StandardRequestInterface
{
    public function getAllCustomersAssociations(?int $id): array;
}
