<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Auth;

use D630\Corg\Model\Model;

class Auth extends Model
{
    public function __construct(string $for = null)
    {
        parent::__construct(__NAMESPACE__, $for ?? 'Standard');
    }
}
