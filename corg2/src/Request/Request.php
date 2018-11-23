<?php

declare(strict_types=1);

namespace D630\Corg\Request;

use D630\Corg\Model\Db\Db;

class Request
{
    public function beginTransaction(): void
    {
        Db::getInstance()
            ->beginTransaction();
    }

    public function commit(): void
    {
        Db::getInstance()
            ->commit();
    }

    public function errorInfo(): void
    {
        Db::getInstance()
            ->errorInfo();
    }

    public function nullifyInt(?int $int): ?int
    {
        return empty($int) ? null : $int;
    }

    public function nullifyStr(?string $str): ?string
    {
        return empty(trim($str)) ? null : trim($str);
    }

    public function rollBack(): void
    {
        Db::getInstance()
            ->rollBack();
    }
}
