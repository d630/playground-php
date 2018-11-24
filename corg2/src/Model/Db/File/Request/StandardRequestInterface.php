<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\File\Request;

use D630\Corg\Request\StandardRequestInterface as PStandardRequestInterface;

interface StandardRequestInterface extends PStandardRequestInterface
{
    public function getAllActivitiesFileIds(?int $id): array;

    public function getAllActivitiesFiles(?int $id): array;

    public function getAllCustomersFileIds(?int $id): array;

    public function getAllCustomersFiles(?int $id): array;

    public function getAllFileIds(): array;

    public function getAllFiles(): array;

    public function getEmployeesLastFileId(?int $id): int;

    public function getFile(?int $id, ?string $entityType): array;

    public function getLastFileId(): int;

    public function getOrphans(): array;

    public function setFile(
        ?int $size,
        ?string $mtype,
        ?string $name,
        ?string $description,
        ?int $employee_id
    ): void;

    public function unsetAllActivitiesFiles(?int $id): void;

    public function unsetAllCustomersFiles(?int $id): void;

    public function unsetAllFiles(): void;

    public function unsetFile(?int $id): void;

    public function unsetOrphans(): void;
}
