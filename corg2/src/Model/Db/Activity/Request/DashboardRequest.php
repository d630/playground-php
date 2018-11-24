<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Activity\Request;

use D630\Corg\Model\Db\Db;

class DashboardRequest extends StandardRequest implements DashboardRequestInterface
{
    public function getAllActivities(): array
    {
        return Db::getInstance()
            ->query('CALL get_all_activities_for_dashboard()')
            ->fetchALL(\PDO::FETCH_FUNC, static function ($id, $mtime, $org, $name): array {
                return [
                    'id' => (int) $id,
                    'mtime' => (int) $mtime,
                    'org' => $org,
                    'name' => $name,
                ];
            });
    }
}
