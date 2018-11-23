<?php

declare(strict_types=1);

namespace D630\Corg\Entity;

use D630\Corg\Request\RequestInterface;

class Customer implements \JsonSerializable, EntityInterface
{
    private $__keys = [];
    private $additional_name;
    private $country_name;
    private $email;
    private $employee_id;
    private $extended_address;
    private $family_name;
    private $given_name;
    private $honorific_prefix;
    private $honorific_suffix;
    private $id;
    private $locality;
    private $org;
    private $post_office_box;
    private $postal_code;
    private $region;
    private $rev;
    private $role;
    private $street_address;
    private $tel;
    private $url;

    public function __getKeys(): array
    {
        return $this->__keys;
    }

    public static function get(int $id, RequestInterface $model)
    {
        return $model->getCustomer($id, __CLASS__);
    }

    public function assignProps(self $entity): void
    {
        foreach ($entity->__getKeys() as $v) {
            $m1 = 'set' . $v;
            $m2 = 'get' . $v;
            $this->{$m1}($entity->{$m2}());
        }
    }

    public function getAdditionalName(): string
    {
        return (string) $this->additional_name;
    }

    public function getCountryName(): string
    {
        return (string) $this->country_name;
    }

    public function getEmail(): string
    {
        return (string) $this->email;
    }

    public function getEmployeeId(): int
    {
        return (int) $this->employee_id;
    }

    public function getExtendedAddress(): string
    {
        return (string) $this->extended_address;
    }

    public function getFamilyName(): string
    {
        return (string) $this->family_name;
    }

    public function getGivenName(): string
    {
        return (string) $this->given_name;
    }

    public function getHonorificPrefix(): string
    {
        return (string) $this->honorific_prefix;
    }

    public function getHonorificSuffix(): string
    {
        return (string) $this->honorific_suffix;
    }

    public function getId(): int
    {
        return (int) $this->id;
    }

    public function getLocality(): string
    {
        return (string) $this->locality;
    }

    public function getOrg(): string
    {
        return (string) $this->org;
    }

    public function getPostalCode(): string
    {
        return (string) $this->postal_code;
    }

    public function getPostOfficeBox(): string
    {
        return (string) $this->post_office_box;
    }

    public function getRegion(): string
    {
        return (string) $this->region;
    }

    public function getRev(): string
    {
        return (string) $this->rev;
    }

    public function getRole(): string
    {
        return (string) $this->role;
    }

    public function getStreetAddress(): string
    {
        return (string) $this->street_address;
    }

    public function getTel(): string
    {
        return (string) $this->tel;
    }

    public function getUrl(): string
    {
        return (string) $this->url;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'family_name' => $this->getFamilyName(),
            'given_name' => $this->getGivenName(),
            'additional_name' => $this->getAdditionalName(),
            'honorific_prefix' => $this->getHonorificPrefix(),
            'honorific_suffix' => $this->getHonorificSuffix(),
            'role' => $this->getRole(),
            'org' => $this->getOrg(),
            'post_office_box' => $this->getPostOfficeBox(),
            'street_address' => $this->getStreetAddress(),
            'extended_address' => $this->getExtendedAddress(),
            'locality' => $this->getLocality(),
            'region' => $this->getRegion(),
            'postal_code' => $this->getPostalCode(),
            'country_name' => $this->getCountryName(),
            'tel' => $this->getTel(),
            'email' => $this->getEmail(),
            'url' => $this->getUrl(),
            'rev' => $this->getRev(),
            'employee_id' => $this->getEmployeeId(),
        ];
    }

    public function postMultiple(array $entityTypes, RequestInterface $model): void
    {
        try {
            $model->beginTransaction();
            foreach ($entityTypes as $v) {
                $model->setCustomer(
                    $v->getFamilyName(),
                    $v->getGivenName(),
                    $v->getAdditionalName(),
                    $v->getHonorificPrefix(),
                    $v->getHonorificSuffix(),
                    $v->getRole(),
                    $v->getOrg(),
                    $v->getPostOfficeBox(),
                    $v->getStreetAddress(),
                    $v->getExtendedAddress(),
                    $v->getLocality(),
                    $v->getRegion(),
                    $v->getPostalCode(),
                    $v->getCountryName(),
                    $v->getTel(),
                    $v->getEmail(),
                    $v->getUrl(),
                    $v->getEmployeeId()
                );
            }
            $model->commit();
        } catch (\Exception $e) {
            $model->rollBack();
            throw new \Exception($e->getMessage(), 500);
        }
    }

    public function put(RequestInterface $model): void
    {
        try {
            $model->beginTransaction();
            $model->resetCustomer(
                $this->getId(),
                $this->getFamilyName(),
                $this->getGivenName(),
                $this->getAdditionalName(),
                $this->getHonorificPrefix(),
                $this->getHonorificSuffix(),
                $this->getRole(),
                $this->getOrg(),
                $this->getPostOfficeBox(),
                $this->getStreetAddress(),
                $this->getExtendedAddress(),
                $this->getLocality(),
                $this->getRegion(),
                $this->getPostalCode(),
                $this->getCountryName(),
                $this->getTel(),
                $this->getEmail(),
                $this->getUrl()
            );
            $model->commit();
        } catch (\Exception $e) {
            $model->rollBack();
            throw new \Exception($e->getMessage(), 500);
        }
    }

    public function setAdditionalName(?string $additional_name = null): void
    {
        $this->additional_name = $additional_name;
    }

    public function setCountryName(?string $country_name = null): void
    {
        $this->country_name = $country_name;
    }

    public function setEmail(?string $email = null): void
    {
        $this->email = $email;
    }

    public function setEmployeeId(?int $employee_id = null): void
    {
        $this->employee_id = $employee_id;
    }

    public function setExtendedAddress(?string $extended_address = null): void
    {
        $this->extended_address = $extended_address;
    }

    public function setFamilyName(?string $family_name = null): void
    {
        $this->family_name = $family_name;
    }

    public function setGivenName(?string $given_name = null): void
    {
        $this->given_name = $given_name;
    }

    public function setHonorificPrefix(?string $honorific_prefix = null): void
    {
        $this->honorific_prefix = $honorific_prefix;
    }

    public function setHonorificSuffix(?string $honorific_suffix = null): void
    {
        $this->honorific_suffix = $honorific_suffix;
    }

    public function setId(?int $id = null): void
    {
        $this->id = $id;
    }

    public function setLocality(?string $locality = null): void
    {
        $this->locality = $locality;
    }

    public function setOrg(?string $org = null): void
    {
        $this->org = $org;
    }

    public function setPostalCode(?string $postal_code = null): void
    {
        $this->postal_code = $postal_code;
    }

    public function setPostOfficeBox(?string $post_office_box = null): void
    {
        $this->post_office_box = $post_office_box;
    }

    public function setRegion(?string $region = null): void
    {
        $this->region = $region;
    }

    public function setRev(?string $rev = null): void
    {
        $this->rev = $rev;
    }

    public function setRole(?string $role = null): void
    {
        $this->role = $role;
    }

    public function setStreetAddress(?string $street_address = null): void
    {
        $this->street_address = $street_address;
    }

    public function setTel(?string $tel = null): void
    {
        $this->tel = $tel;
    }

    public function setUrl(?string $url = null): void
    {
        $this->url = $url;
    }
}
