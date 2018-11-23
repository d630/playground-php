<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Customer\Request;

use D630\Corg\Model\Db\Db;

class FetchRequest extends StandardRequest implements FetchRequestInterface
{
    public function getAllCustomers(): array
    {
        return Db::getInstance()
            ->query('CALL get_all_customers_tiny()')
            ->fetchALL(\PDO::FETCH_FUNC, [$this, 'mapAllFetch']);
    }

    public function getAllFilesCustomers(?int $id): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_all_files_customers_tiny(:id)');
        $pod->execute(['id' => $this->nullifyInt($id)]);

        return $pod->fetchALL(\PDO::FETCH_FUNC, [$this, 'mapAllFetch']);
    }

    public function mapAllFetch($id, $org): array
    {
        return [
            'id' => (int) $id,
            'org' => $org,
        ];
    }
}
