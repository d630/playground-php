<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Reference\Request;

use D630\Corg\Request\StandardRequestInterface as PStandardRequestInterface;

interface StandardRequestInterface extends PStandardRequestInterface
{
    public function getAllReferences(): array;

    public function setReference(?int $activity_id, ?int $file_id): void;

    public function unsetAllActivitiesReferences(?int $id): void;

    public function unsetAllFilesReferences(?int $id): void;

    public function unsetAllReferences(): void;

    public function unsetReference(?int $activity_id, ?int $file_id): void;
}
