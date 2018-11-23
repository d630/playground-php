<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\File\Request;

interface FetchRequestInterface extends StandardRequestInterface
{
    public function getAllActivitiesFiles(?int $id): array;

    public function getAllCustomersFiles(?int $id): array;

    public function getAllFiles(): array;
}
