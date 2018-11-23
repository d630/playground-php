<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Association\Request;

use D630\Corg\Model\Db\Db;
use D630\Corg\Request\StandardRequest as PStandardRequest;

class StandardRequest extends PStandardRequest implements StandardRequestInterface
{
    public function checkAssociation(?int $customer_id_1, ?int $customer_id_2): void
    {
        Db::getInstance()
            ->prepare('CALL check_association_pair(:customer_id_1, :customer_id_2)')
            ->execute(
                [
                    'customer_id_1' => $this->nullifyInt($customer_id_1),
                    'customer_id_2' => $this->nullifyInt($customer_id_2),
                ]
            );
    }

    public function getAllAssociations(): array
    {
        return Db::getInstance()
            ->query('CALL get_all_associations()')
            ->fetchALL(\PDO::FETCH_FUNC, static function ($customer_id_1, $customer_id_2): array {
                return [
                    'customer_id_1' => (int) $customer_id_1,
                    'customer_id_2' => (int) $customer_id_2,
                ];
            });
    }

    public function getAllCustomersAssociations(?int $id): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_all_customers_associations(:id)');
        $pod->execute(['id' => $this->nullifyInt($id)]);

        return $pod->fetchALL(\PDO::FETCH_FUNC, static function (
            $id, $family_name, $given_name, $additional_name,
            $honorific_prefix, $honorific_suffix, $role, $org,
            $post_office_box, $street_address, $extended_address,
            $locality, $region, $postal_code, $country_name, $tel, $email,
            $url, $rev, $employee_Id): array {
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
        });
    }

    public function setAssociation(?int $customer_id_1, ?int $customer_id_2): void
    {
        Db::getInstance()
            ->prepare('CALL set_association(:customer_id_1, :customer_id_2)')
            ->execute(
                [
                    'customer_id_1' => $this->nullifyInt($customer_id_1),
                    'customer_id_2' => $this->nullifyInt($customer_id_2),
                ]
            );
    }

    public function unsetAllAssociations(): void
    {
        Db::getInstance()
            ->exec('CALL unset_all_associations()');
    }

    public function unsetAllCustomersAssociations(?int $id): void
    {
        Db::getInstance()
            ->prepare('CALL unset_all_customers_associations(:id)')
            ->execute(['id' => $this->nullifyInt($id)]);
    }

    public function unsetAssociation(?int $customer_id_1, ?int $customer_id_2): void
    {
        Db::getInstance()
            ->prepare('CALL unset_association(:customer_id_1, :customer_id_2)')
            ->execute(
                [
                    'customer_id_1' => $this->nullifyInt($customer_id_1),
                    'customer_id_2' => $this->nullifyInt($customer_id_2),
                ]
            );
    }
}
