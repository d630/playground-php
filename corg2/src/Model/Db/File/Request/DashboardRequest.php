<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\File\Request;

use D630\Corg\Model\Db\Db;

class DashboardRequest extends StandardRequest implements DashboardRequestInterface
{
    public function getAllFiles(): array
    {
        return Db::getInstance()
            ->query('CALL get_all_files_for_dashboard()')
            ->fetchALL(\PDO::FETCH_FUNC, static function ($id, $mtime, $name, $activity_name): array {
                return [
                    'id' => (int) $id,
                    'mtime' => (int) $mtime,
                    'name' => $name,
                    'activity_name' => $activity_name,
                ];
            });
    }
}
