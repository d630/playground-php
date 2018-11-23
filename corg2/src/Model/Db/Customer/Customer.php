<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Customer;

use D630\Corg\Model\Model;

class Customer extends Model
{
    public function __construct(string $for = null)
    {
        parent::__construct(__NAMESPACE__, $for ?? 'Standard');
    }
}
