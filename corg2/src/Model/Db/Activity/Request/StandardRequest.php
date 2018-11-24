<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Activity\Request;

use D630\Corg\Model\Db\Db;
use D630\Corg\Request\StandardRequest as PStandardRequest;

class StandardRequest extends PStandardRequest implements StandardRequestInterface
{
    public function getActivity(?int $id, ?string $entityType): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_activity(:id)');
        $pod->execute(['id' => $this->nullifyInt($id)]);

        return [$pod->fetchObject($entityType)];
    }

    public function getAllActivities(): array
    {
        return Db::getInstance()
            ->query('CALL get_all_activities()')
            ->fetchALL(\PDO::FETCH_FUNC, [$this, 'mapAll']);
    }

    public function getAllCustomersActivities(?int $id): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_all_customers_activities(:id)');
        $pod->execute(['id' => $this->nullifyInt($id)]);

        return $pod->fetchALL(\PDO::FETCH_FUNC, [$this, 'mapAll']);
    }

    public function getAllFilesActivities(?int $id): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_all_files_activities(:id)');
        $pod->execute(['id' => $this->nullifyInt($id)]);

        return $pod->fetchALL(\PDO::FETCH_FUNC, [$this, 'mapAll']);
    }

    public function getLastActivityId(): int
    {
        return (int) Db::getInstance()
            ->query('CALL get_last_activity_id()')
            ->fetchColumn();
    }

    public function mapAll($id, $mtime, $name, $description, $customer_id, $employee_id): array
    {
        return [
            'customer_id' => (int) $customer_id,
            'description' => (string) $description,
            'employee_id' => (int) $employee_id,
            'id' => (int) $id,
            'mtime' => (int) $mtime,
            'name' => $name,
        ];
    }

    public function setActivity(?string $name, ?string $description, ?int $customer_id, ?int $employee_id): void
    {
        Db::getInstance()
            ->prepare('CALL set_activity(:name, :description, :customer_id, :employee_id)')
            ->execute(
                [
                    'name' => $this->nullifyStr($name),
                    'description' => $this->nullifyStr($description),
                    'customer_id' => $this->nullifyInt($customer_id),
                    'employee_id' => $this->nullifyInt($employee_id),
                ]
            );
    }

    public function unsetActivity(?int $id): void
    {
        Db::getInstance()
            ->prepare('CALL unset_activity(:id)')
            ->execute(['id' => $this->nullifyInt($id)]);
    }

    public function unsetAllActivities(): void
    {
        Db::getInstance()
            ->exec('CALL unset_all_activities()');
    }

    public function unsetAllCustomersActivities(?int $id): void
    {
        Db::getInstance()
            ->prepare('CALL unset_all_customers_activities(:id)')
            ->execute(['id' => $this->nullifyInt($id)]);
    }

    public function unsetAllFilesActivities(?int $id): void
    {
        Db::getInstance()
            ->prepare('CALL unset_all_files_activities(:id)')
            ->execute(['id' => $this->nullifyInt($id)]);
    }
}
