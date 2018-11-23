<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Reference\Request;

use D630\Corg\Model\Db\Db;
use D630\Corg\Request\StandardRequest as PStandardRequest;

class StandardRequest extends PStandardRequest implements StandardRequestInterface
{
    public function getAllReferences(): array
    {
        return Db::getInstance()
            ->query('CALL get_all_references()')
            ->fetchALL(\PDO::FETCH_FUNC, static function ($activity_id, $file_id): array {
                return [
                    'activity_id' => (int) $activity_id,
                    'file_id' => (int) $file_id,
                ];
            }
        );
    }

    public function setReference(?int $activity_id, ?int $file_id): void
    {
        Db::getInstance()
            ->prepare('CALL set_reference(:activity_id, :file_id)')
            ->execute(
                [
                    'activity_id' => $this->nullifyInt($activity_id),
                    'file_id' => $this->nullifyInt($file_id),
                ]
            );
    }

    public function unsetAllActivitiesReferences(?int $id): void
    {
        Db::getInstance()
            ->prepare('CALL unset_all_activities_references(:id)')
            ->execute(['id' => $this->nullifyInt($id)]);
    }

    public function unsetAllFilesReferences(?int $id): void
    {
        Db::getInstance()
            ->prepare('CALL unset_all_files_references(:id)')
            ->execute(['id' => $this->nullifyInt($id)]);
    }

    public function unsetAllReferences(): void
    {
        Db::getInstance()
            ->exec('CALL unset_all_references()');
    }

    public function unsetReference(?int $activity_id, ?int $file_id): void
    {
        Db::getInstance()
            ->prepare('CALL untset_reference(:activity_id, :file_id)')
            ->execute(
                [
                    'activity_id' => $this->nullifyInt($activity_id),
                    'file_id' => $this->nullifyInt($file_id),
                ]
            );
    }
}
