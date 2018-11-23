<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\File\Request;

use D630\Corg\Model\Db\Db;
use D630\Corg\Request\StandardRequest as PStandardRequest;

class StandardRequest extends PStandardRequest implements StandardRequestInterface
{
    public function getAllActivitiesFileIds(?int $id): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_all_activities_file_ids(:id)');
        $pod->execute(['id' => $this->nullifyInt($id)]);

        return $pod->fetchALL(\PDO::FETCH_COLUMN);
    }

    public function getAllActivitiesFiles(?int $id): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_all_activities_files(:id)');
        $pod->execute(['id' => $this->nullifyInt($id)]);

        return $pod->fetchALL(\PDO::FETCH_FUNC, [$this, 'mapAll']);
    }

    public function getAllCustomersFileIds(?int $id): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_all_customers_file_ids(:id)');
        $pod->execute(['id' => $this->nullifyInt($id)]);

        return $pod->fetchALL(\PDO::FETCH_COLUMN);
    }

    public function getAllCustomersFiles(?int $id): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_all_customers_files(:id)');
        $pod->execute(['id' => $this->nullifyInt($id)]);

        return $pod->fetchALL(\PDO::FETCH_FUNC, [$this, 'mapAll']);
    }

    public function getAllFileIds(): array
    {
        return Db::getInstance()
            ->query('CALL get_all_file_ids()')
            ->fetchALL(\PDO::FETCH_COLUMN);
    }

    public function getAllFiles(): array
    {
        return Db::getInstance()
            ->query('CALL get_all_files()')
            ->fetchALL(\PDO::FETCH_FUNC, [$this, 'mapAll']);
    }

    public function getFile(?int $id, ?string $entityType): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_file(:id)');
        $pod->execute(['id' => $this->nullifyInt($id)]);

        return [$pod->fetchObject($entityType)];
    }

    public function getLastFileId(): int
    {
        return (int) Db::getInstance()
            ->query('CALL get_last_file_id()')
            ->fetchColumn();
    }

    public function getOrphans(): array
    {
        return Db::getInstance()
            ->query('CALL get_orphans()')
            ->fetchALL(\PDO::FETCH_FUNC, static function ($id): array {
                return (int) $id;
            });
    }

    public function mapAll($id, $mtime, $size, $mtype, $name, $description, $employee_id): array
    {
        return [
            'description' => (string) $description,
            'employee_id' => (int) $employee_id,
            'id' => (int) $id,
            'mtime' => $mtime,
            'mtype' => $mtype,
            'name' => $name,
            'size' => (int) $size,
        ];
    }

    public function setFile(
        ?int $size,
        ?string $mtype,
        ?string $name,
        ?string $description,
        ?int $employee_id
    ): void {
        Db::getInstance()
            ->prepare('CALL set_file(:size, :mtype, :name, :description, :employee_id)')
            ->execute(
                [
                    'size' => $this->nullifyInt($size),
                    'mtype' => $this->nullifyStr($mtype),
                    'name' => $this->nullifyStr($name),
                    'description' => $this->nullifyStr($description),
                    'employee_id' => $this->nullifyInt($employee_id),
                ]
            );
    }

    public function unsetAllActivitiesFiles(?int $id): void
    {
        Db::getInstance()
            ->prepare('CALL unset_all_activities_files(:id)')
            ->execute(['id' => $this->nullifyInt($id)]);
    }

    public function unsetAllCustomersFiles(?int $id): void
    {
        Db::getInstance()
            ->prepare('CALL unset_all_customers_files(:id)')
            ->execute(['id' => $this->nullifyInt($id)]);
    }

    public function unsetAllFiles(): void
    {
        Db::getInstance()
            ->exec('CALL unset_all_files()');
    }

    public function unsetFile(?int $id): void
    {
        Db::getInstance()
            ->prepare('CALL unset_file(:id)')
            ->execute(['id' => $this->nullifyInt($id)]);
    }

    public function unsetOrphans(): void
    {
        Db::getInstance()
            ->exec('CALL unset_orphans()');
    }
}
