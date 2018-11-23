<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Activity\Request;

use D630\Corg\Request\StandardRequestInterface as PStandardRequestInterface;

interface StandardRequestInterface extends PStandardRequestInterface
{
    public function getActivity(?int $id, ?string $entityType): array;

    public function getAllActivities(): array;

    public function getAllCustomersActivities(?int $id): array;

    public function getAllFilesActivities(?int $id): array;

    public function getLastActivityId(): int;

    public function mapAll($id, $mtime, $name, $description, $customer_id, $employee_id): array;

    public function setActivity(?string $name, ?string $description, ?int $customer_id, ?int $employee_id): void;

    public function unsetActivity(?int $id): void;

    public function unsetAllActivities(): void;

    public function unsetAllCustomersActivities(?int $id): void;

    public function unsetAllFilesActivities(?int $id): void;
}
