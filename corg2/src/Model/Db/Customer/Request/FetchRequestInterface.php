<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Customer\Request;

interface FetchRequestInterface extends StandardRequestInterface
{
    public function getAllCustomers(): array;

    public function getAllFilesCustomers(?int $id): array;
}
