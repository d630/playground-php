<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Activity\Request;

interface DashboardRequestInterface extends StandardRequestInterface
{
    public function getAllActivities(): array;
}
