<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Activity\Request;

interface FetchRequestInterface extends StandardRequestInterface
{
    public function getAllActivities(): array;

    public function getAllCustomersActivities(?int $id): array;

    public function getAllFilesActivities(?int $id): array;

    public function mapAllFetch($id, $mtime, $name, $description): array;
}
