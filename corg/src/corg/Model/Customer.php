<?php

namespace corg\Model;

class Customer extends \corg\Model
{
    public function getAllCustomersTiny() { return \corg\Db::getInstance() ->query('CALL get_all_customers_tiny()') ->fetchALL(\PDO::FETCH_KEY_PAIR);
    }

    public function getAllCustomersTinyFlip()
    {
        return \corg\Db::getInstance()
            ->query('CALL get_all_customers_tiny_flip()')
            ->fetchALL(\PDO::FETCH_KEY_PAIR);
    }

    public function getAllCustomersShort()
    {
        return \corg\Db::getInstance()
            ->query('CALL get_all_customers_short()')
            ->fetchALL(\PDO::FETCH_UNIQUE);
    }

    public function getCustomer($id)
    {
        $pod = \corg\Db::getInstance()
            ->prepare('CALL get_customer(:id)');
        $pod->execute(['id' => $this->nullifyStr($id)]);

        return $pod->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAssociations($id)
    {
        $pod = \corg\Db::getInstance()
            ->prepare('CALL get_associations(:id)');
        $pod->execute(['id' => $this->nullifyStr($id)]);

        return $pod->fetchALL(\PDO::FETCH_KEY_PAIR);
    }

    public function getAbleToAssociateDirty($id)
    {
        $pod = \corg\Db::getInstance()
            ->prepare('CALL get_able_to_associate_dirty(:id)');
        $pod->execute(['id' => $this->nullifyStr($id)]);

        return $pod->fetchALL(\PDO::FETCH_KEY_PAIR);
    }

    public function setCustomer($family_name, $given_name, $additional_name,
        $honorific_prefix, $honorific_suffix, $role, $org, $post_office_box,
        $street_address, $extended_address, $locality, $region, $postal_code,
        $country_name, $tel, $email, $url, $employee_id)
    {
        \corg\Db::getInstance()
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
                    'employee_id' => $this->nullifyStr($employee_id)
                ]
            );
    }

    public function resetCustomer($family_name, $given_name, $additional_name,
        $honorific_prefix, $honorific_suffix, $role, $post_office_box,
        $street_address, $extended_address, $locality, $region, $postal_code,
        $country_name, $tel, $email, $url)
    {
        \corg\Db::getInstance()
            ->prepare('CALL reset_customer(:family_name, :given_name,
                :additional_name, :honorific_prefix, :honorific_suffix, :role,
                :post_office_box, :street_address, :extended_address,
                :locality, :region, :postal_code, :country_name, :tel, :email,
                :url)')
            ->execute(
                [
                    'family_name' => $this->nullifyStr($family_name),
                    'given_name' => $this->nullifyStr($given_name),
                    'additional_name' => $this->nullifyStr($additional_name),
                    'honorific_prefix' => $this->nullifyStr($honorific_prefix),
                    'honorific_suffix' => $this->nullifyStr($honorific_suffix),
                    'role' => $this->nullifyStr($role),
                    'post_office_box' => $this->nullifyStr($post_office_box),
                    'street_address' => $this->nullifyStr($street_address),
                    'extended_address' => $this->nullifyStr($extended_address),
                    'locality' => $this->nullifyStr($locality),
                    'region' => $this->nullifyStr($region),
                    'postal_code' => $this->nullifyStr($postal_code),
                    'country_name' => $this->nullifyStr($country_name),
                    'tel' => $this->nullifyStr($tel),
                    'email' => $this->nullifyStr($email),
                    'url' => $this->nullifyStr($url)
                ]
            );
    }

    public function setAssociation($customer_id_1, $customer_id_2)
    {
        \corg\Db::getInstance()
            ->prepare('CALL set_association(:customer_id_1, :customer_id_2)')
            ->execute(
                [
                    'customer_id_1' => $this->nullifyStr($customer_id_1),
                    'customer_id_2' => $this->nullifyStr($customer_id_2)
                ]
            );
    }

    public function getLastCustomerId()
    {
        return \corg\Db::getInstance()
            ->query('CALL get_last_customer_id()')
            ->fetchColumn();
    }

    public function unsetCustomer($id)
    {
        \corg\Db::getInstance()
            ->prepare('CALL unset_customer(:id)')
            ->execute(['id' => $id]);
    }

    public function unsetAssociation($customer_id_1, $customer_id_2)
    {
        \corg\Db::getInstance()
            ->prepare('CALL unset_association(:customer_id_1, :customer_id_2)')
            ->execute(
                [
                    'customer_id_1' => $this->nullifyStr($customer_id_1),
                    'customer_id_2' => $this->nullifyStr($customer_id_2)
                ]
            );
    }
}
