<?php

declare(strict_types=1);

namespace D630\Corg\Export;

use D630\Corg\Entity\Customer;
use JeroenDesloovere\VCard\VCard;

class VcardExporter implements ExporterInterface
{
    private $vcard;

    public function __construct()
    {
        $this->vcard = new VCard();
    }

    public function convert(Customer $customer): void
    {
        $this->vcard->addAddress(
            null,
            $customer->getExtendedAddress(),
            $customer->getStreetAddress(),
            $customer->getLocality(),
            $customer->getRegion(),
            $customer->getPostalCode(),
            $customer->getCountryName(),
            'WORK;POSTAL'
        );

        $this->vcard->addCompany($customer->getOrg(), null);
        $this->vcard->addEmail($customer->getEmail(), 'PREF;WORK');
        $this->vcard->addRole($customer->getRole());

        $this->vcard->addName(
            $customer->getFamilyName(),
            $customer->getGivenName(),
            $customer->getAdditionalName(),
            $customer->getHonorificPrefix(),
            $customer->getHonorificSuffix()
        );

        $this->vcard->addPhoneNumber($customer->getTel(), 'PREF;WORK;VOICE');
        $this->vcard->addURL($customer->getUrl(), 'WORK');
    }

    public function output(): void
    {
        echo $this->vcard->getOutput();
    }
}
