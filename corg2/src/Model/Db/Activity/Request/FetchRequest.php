<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Activity\Request;

use D630\Corg\Model\Db\Db;

class FetchRequest extends StandardRequest implements FetchRequestInterface
{
    public function getAllActivities(): array
    {
        return Db::getInstance()
            ->query('CALL get_all_activities_tiny()')
            ->fetchALL(\PDO::FETCH_FUNC, static function ($id, $name): array {
                return [
                    'id' => (int) $id,
                    'name' => $name,
                ];
            });
    }

    public function getAllCustomersActivities(?int $id): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_all_customers_activities_tiny(:id)');
        $pod->execute(['id' => $this->nullifyInt($id)]);

        return $pod->fetchALL(\PDO::FETCH_FUNC, [$this, 'mapAllFetch']);
    }

    public function getAllFilesActivities(?int $id): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_all_files_activities_tiny(:id)');
        $pod->execute(['id' => $this->nullifyInt($id)]);

        return $pod->fetchALL(\PDO::FETCH_FUNC, [$this, 'mapAllFetch']);
    }

    public function mapAllFetch($id, $mtime, $name, $description): array
    {
        return [
            'description' => (string) $description,
            'id' => (int) $id,
            'mtime' => (int) $mtime,
            'name' => $name,
        ];
    }
}
