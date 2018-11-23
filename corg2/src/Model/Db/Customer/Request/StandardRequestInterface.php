<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Customer\Request;

use D630\Corg\Request\StandardRequestInterface as PStandardRequestInterface;

interface StandardRequestInterface extends PStandardRequestInterface
{
    public function getAllCustomers(): array;

    public function getAllFilesCustomers(?int $id): array;

    public function getCustomer(?int $id, ?string $entityType): array;

    public function getLastCustomerId(): int;

    public function mapAll(
        $id, $family_name, $given_name, $additional_name, $honorific_prefix,
        $honorific_suffix, $role, $org, $post_office_box, $street_address,
        $extended_address, $locality, $region, $postal_code, $country_name,
        $tel, $email, $url, $rev, $employee_Id
    ): array;

    public function resetCustomer(
        ?int $id,
        ?string $family_name,
        ?string $given_name,
        ?string $additional_name,
        ?string $honorific_prefix,
        ?string $honorific_suffix,
        ?string $role,
        ?string $org,
        ?string $post_office_box,
        ?string $street_address,
        ?string $extended_address,
        ?string $locality,
        ?string $region,
        ?string $postal_code,
        ?string $country_name,
        ?string $tel,
        ?string $email,
        ?string $url
    ): void;

    public function setCustomer(
        ?string $family_name,
        ?string $given_name,
        ?string $additional_name,
        ?string $honorific_prefix,
        ?string $honorific_suffix,
        ?string $role,
        ?string $org,
        ?string $post_office_box,
        ?string $street_address,
        ?string $extended_address,
        ?string $locality,
        ?string $region,
        ?string $postal_code,
        ?string $country_name,
        ?string $tel,
        ?string $email,
        ?string $url,
        ?int $employee_id
    ): void;

    public function unsetAllCustomers(): void;

    public function unsetAllFilesCustomers(?int $id): void;

    public function unsetCustomer(?int $id): void;
}
