<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Customer\Request;

use D630\Corg\Model\Db\Db;

class DashboardRequest extends StandardRequest implements DashboardRequestInterface
{
    public function getAllCustomers(): array
    {
        return Db::getInstance()
            ->query('CALL get_all_customers_for_dashboard()')
            ->fetchALL(\PDO::FETCH_FUNC, static function ($id, $rev, $org): array {
                return [
                    'id' => (int) $id,
                    'rev' => $rev,
                    'org' => $org,
                ];
            });
    }
}
