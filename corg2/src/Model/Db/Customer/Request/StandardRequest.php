<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Customer\Request;

use D630\Corg\Model\Db\Db;
use D630\Corg\Request\StandardRequest as PStandardRequest;

class StandardRequest extends PStandardRequest implements StandardRequestInterface
{
    public function getAllCustomers(): array
    {
        return Db::getInstance()
            ->query('CALL get_all_customers()')
            ->fetchALL(\PDO::FETCH_FUNC, [$this, 'mapAll']);
    }

    public function getAllFilesCustomers(?int $id): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_all_files_customers(:id)');
        $pod->execute(['id' => $this->nullifyInt($id)]);

        return $pod->fetchALL(\PDO::FETCH_FUNC, [$this, 'mapAll']);
    }

    public function getCustomer(?int $id, ?string $entityType): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_customer(:id)');
        $pod->execute(['id' => $this->nullifyInt($id)]);

        return [$pod->fetchObject($entityType)];
    }

    public function getLastCustomerId(): int
    {
        return (int) Db::getInstance()
            ->query('CALL get_last_customer_id()')
            ->fetchColumn();
    }

    public function mapAll(
        $id, $family_name, $given_name, $additional_name, $honorific_prefix,
        $honorific_suffix, $role, $org, $post_office_box, $street_address,
        $extended_address, $locality, $region, $postal_code, $country_name,
        $tel, $email, $url, $rev, $employee_Id
    ): array {
        return [
            'additional_name' => (string) $additional_name,
            'country_name' => (string) $country_name,
            'email' => (string) $email,
            'employee_id' => (int) $employee_Id,
            'extended_address' => (string) $extended_address,
            'family_name' => $family_name,
            'given_name' => $given_name,
            'honorific_prefix' => (string) $honorific_prefix,
            'honorific_suffix' => (string) $honorific_suffix,
            'id' => (int) $id,
            'locality' => (string) $locality,
            'org' => $org,
            'post_office_box' => (string) $post_office_box,
            'postal_code' => (string) $postal_code,
            'region' => (string) $region,
            'rev' => $rev,
            'role' => $role,
            'street_address' => (string) $street_address,
            'tel' => (string) $tel,
            'url' => (string) $url,
        ];
    }

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
    ): void {
        Db::getInstance()
            ->prepare('CALL reset_customer(:id, :family_name, :given_name,
                :additional_name, :honorific_prefix, :honorific_suffix, :role,
                :org, :post_office_box, :street_address, :extended_address,
                :locality, :region, :postal_code, :country_name, :tel, :email,
                :url)')
            ->execute(
                [
                    'id' => $this->nullifyInt($id),
                    'family_name' => $this->nullifyStr($family_name),
                    'given_name' => $this->nullifyStr($given_name),
                    'additional_name' => $this->nullifyStr($additional_name),
                    'honorific_prefix' => $this->nullifyStr($honorific_prefix),
                    'honorific_suffix' => $this->nullifyStr($honorific_suffix),
                    'role' => $this->nullifyStr($role),
                    'org' => $this->nullifyStr($org),
                    'post_office_box' => $this->nullifyStr($post_office_box),
                    'street_address' => $this->nullifyStr($street_address),
                    'extended_address' => $this->nullifyStr($extended_address),
                    'locality' => $this->nullifyStr($locality),
                    'region' => $this->nullifyStr($region),
                    'postal_code' => $this->nullifyStr($postal_code),
                    'country_name' => $this->nullifyStr($country_name),
                    'tel' => $this->nullifyStr($tel),
                    'email' => $this->nullifyStr($email),
                    'url' => $this->nullifyStr($url),
                ]
            );
    }

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
    ): void {
        Db::getInstance()
            ->prepare('CALL set_customer(:family_name, :given_name,
                :additional_name, :honorific_prefix, :honorific_suffix, :role,
                :org, :post_office_box, :street_address, :extended_address,
                :locality, :region, :postal_code, :country_name, :tel, :email,
                :url, :employee_id)')
            ->execute(
                [
                    'family_name' => $this->nullifyStr($family_name),
                    'given_name' => $this->nullifyStr($given_name),
                    'additional_name' => $this->nullifyStr($additional_name),
                    'honorific_prefix' => $this->nullifyStr($honorific_prefix),
                    'honorific_suffix' => $this->nullifyStr($honorific_suffix),
                    'role' => $this->nullifyStr($role),
                    'org' => $this->nullifyStr($org),
                    'post_office_box' => $this->nullifyStr($post_office_box),
                    'street_address' => $this->nullifyStr($street_address),
                    'extended_address' => $this->nullifyStr($extended_address),
                    'locality' => $this->nullifyStr($locality),
                    'region' => $this->nullifyStr($region),
                    'postal_code' => $this->nullifyStr($postal_code),
                    'country_name' => $this->nullifyStr($country_name),
                    'tel' => $this->nullifyStr($tel),
                    'email' => $this->nullifyStr($email),
                    'url' => $this->nullifyStr($url),
                    'employee_id' => $this->nullifyInt($employee_id),
                ]
            );
    }

    public function unsetAllCustomers(): void
    {
        Db::getInstance()
            ->exec('CALL unset_all_customers()');
    }

    public function unsetAllFilesCustomers(?int $id): void
    {
        Db::getInstance()
            ->prepare('CALL unset_all_files_customers(:id)')
            ->execute(['id' => $this->nullifyInt($id)]);
    }

    public function unsetCustomer(?int $id): void
    {
        Db::getInstance()
            ->prepare('CALL unset_customer(:id)')
            ->execute(['id' => $this->nullifyInt($id)]);
    }
}
