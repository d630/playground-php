<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Association\Request;

use D630\Corg\Request\StandardRequestInterface as PStandardRequestInterface;

interface StandardRequestInterface extends PStandardRequestInterface
{
    public function checkAssociation(?int $customer_id_1, ?int $customer_id_2): void;

    public function getAllAssociations(): array;

    public function getAllCustomersAssociations(?int $id): array;

    public function setAssociation(?int $customer_id_1, ?int $customer_id_2): void;

    public function unsetAllAssociations(): void;

    public function unsetAllCustomersAssociations(?int $id): void;

    public function unsetAssociation(?int $customer_id_1, ?int $customer_id_2): void;
}
