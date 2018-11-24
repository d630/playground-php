<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\File\Request;

use D630\Corg\Model\Db\Db;

class FetchRequest extends StandardRequest implements FetchRequestInterface
{
    public function getAllActivitiesFiles(?int $id): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_all_activities_files_small(:id)');
        $pod->execute(['id' => $this->nullifyInt($id)]);

        return $pod->fetchALL(\PDO::FETCH_FUNC, [$this, 'mapAllFetch']);
    }

    public function getAllCustomersFiles(?int $id): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_all_customers_files_small(:id)');
        $pod->execute(['id' => $this->nullifyInt($id)]);

        return $pod->fetchALL(\PDO::FETCH_FUNC, [$this, 'mapAllFetch']);
    }

    public function getAllFiles(): array
    {
        return Db::getInstance()
            ->query('CALL get_all_files_small()')
            ->fetchALL(\PDO::FETCH_FUNC, static function ($id, $name): array {
                return [
                    'id' => (int) $id,
                    'name' => $name,
                ];
            });
    }

    public function mapAllFetch($id, $mtime, $size, $name): array
    {
        return [
            'id' => (int) $id,
            'mtime' => (int) $mtime,
            'name' => $name,
            'size' => (int) $size,
        ];
    }
}
