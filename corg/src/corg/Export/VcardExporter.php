<?php

namespace corg\Export;

use JeroenDesloovere\VCard\VCard;

class VcardExporter implements Exporter
{
    private $vcard;

    public function __construct() {
        $this->vcard = new VCard();
    }

    public function convert($customer)
    {

        $this->vcard->addAddress(
            null,
            $customer['extended_address'],
            $customer['street_address'],
            $customer['locality'],
            $customer['region'],
            $customer['postal_code'],
            $customer['country_name'],
            'WORK;POSTAL'
        );

        $this->vcard->addCompany($customer['org'], null);
        $this->vcard->addEmail($customer['email'], 'PREF;WORK');
        $this->vcard->addRole($customer['role']);

        $this->vcard->addName(
            $customer['family_name'],
            $customer['given_name'],
            $customer['additional_name'],
            $customer['honorific_prefix'],
            $customer['honorific_suffix']
        );

        $this->vcard->addPhoneNumber($customer['tel'], 'PREF;WORK;VOICE');
        $this->vcard->addURL($customer['url'], 'WORK');
    }

    public function download()
    {
        $this->vcard->download();
    }
}
