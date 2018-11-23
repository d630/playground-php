<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Customer\Request;

interface DashboardRequestInterface extends StandardRequestInterface
{
    public function getAllCustomers(): array;
}
