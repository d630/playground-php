<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Association\Request;

use D630\Corg\Model\Db\Db;

class FetchRequest extends StandardRequest implements FetchRequestInterface
{
    public function getAllCustomersAssociations(?int $id): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_all_customers_associations_small(:id)');
        $pod->execute(['id' => $this->nullifyInt($id)]);

        return $pod->fetchALL(\PDO::FETCH_FUNC, static function ($id, $org): array {
            return [
                'id' => (int) $id,
                'org' => $org,
            ];
        });
    }
}
