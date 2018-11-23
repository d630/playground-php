<?php

declare(strict_types=1);

namespace D630\Corg\Request;

interface RequestInterface
{
    public function beginTransaction(): void;

    public function commit(): void;

    public function errorInfo(): void;

    public function nullifyInt(?int $int): ?int;

    public function nullifyStr(?string $str): ?string;

    public function rollBack(): void;
}
