<?php

declare(strict_types=1);

namespace D630\Corg\Entity;

use Karriere\JsonDecoder\Bindings\CallbackBinding;
use Karriere\JsonDecoder\ClassBindings;
use Karriere\JsonDecoder\Transformer;

class CustomerTransformer implements Transformer
{
    public function register(ClassBindings $classBindings): void
    {
        $classBindings->register(new CallbackBinding('additional_name', static function ($data) use (&$__keys) {
            if (array_key_exists('additional_name', $data)) {
                $__keys[] = 'AdditionalName';
                return $data['additional_name'];
            }
        }));

        $classBindings->register(new CallbackBinding('country_name', static function ($data) use (&$__keys) {
            if (array_key_exists('country_name', $data)) {
                $__keys[] = 'CountryName';
                return $data['country_name'];
            }
        }));

        $classBindings->register(new CallbackBinding('email', static function ($data) use (&$__keys) {
            if (array_key_exists('email', $data)) {
                $__keys[] = 'Email';
                return $data['email'];
            }
        }));

        $classBindings->register(new CallbackBinding('employee_id', static function ($data) use (&$__keys) {
            if (array_key_exists('employee_id', $data)) {
                $__keys[] = 'EmployeeId';
                return $data['employee_id'];
            }
        }));

        $classBindings->register(new CallbackBinding('extended_address', static function ($data) use (&$__keys) {
            if (array_key_exists('extended_address', $data)) {
                $__keys[] = 'ExtendedAddress';
                return $data['extended_address'];
            }
        }));

        $classBindings->register(new CallbackBinding('family_name', static function ($data) use (&$__keys) {
            if (array_key_exists('family_name', $data)) {
                $__keys[] = 'FamilyName';
                return $data['family_name'];
            }
        }));

        $classBindings->register(new CallbackBinding('given_name', static function ($data) use (&$__keys) {
            if (array_key_exists('given_name', $data)) {
                $__keys[] = 'GivenName';
                return $data['given_name'];
            }
        }));

        $classBindings->register(new CallbackBinding('honorific_prefix', static function ($data) use (&$__keys) {
            if (array_key_exists('honorific_prefix', $data)) {
                $__keys[] = 'HonorificPrefix';
                return $data['honorific_prefix'];
            }
        }));

        $classBindings->register(new CallbackBinding('honorific_suffix', static function ($data) use (&$__keys) {
            if (array_key_exists('honorific_suffix', $data)) {
                $__keys[] = 'HonorificSuffix';
                return $data['honorific_suffix'];
            }
        }));

        $classBindings->register(new CallbackBinding('id', static function ($data) use (&$__keys) {
            if (array_key_exists('id', $data)) {
                $__keys[] = 'Id';
                return $data['id'];
            }
        }));

        $classBindings->register(new CallbackBinding('locality', static function ($data) use (&$__keys) {
            if (array_key_exists('locality', $data)) {
                $__keys[] = 'Locality';
                return $data['locality'];
            }
        }));

        $classBindings->register(new CallbackBinding('org', static function ($data) use (&$__keys) {
            if (array_key_exists('org', $data)) {
                $__keys[] = 'Org';
                return $data['org'];
            }
        }));

        $classBindings->register(new CallbackBinding('postal_code', static function ($data) use (&$__keys) {
            if (array_key_exists('postal_code', $data)) {
                $__keys[] = 'PostalCode';
                return $data['postal_code'];
            }
        }));

        $classBindings->register(new CallbackBinding('post_office_box', static function ($data) use (&$__keys) {
            if (array_key_exists('post_office_box', $data)) {
                $__keys[] = 'PostOfficeBox';
                return $data['post_office_box'];
            }
        }));

        $classBindings->register(new CallbackBinding('region', static function ($data) use (&$__keys) {
            if (array_key_exists('region', $data)) {
                $__keys[] = 'Region';
                return $data['region'];
            }
        }));

        $classBindings->register(new CallbackBinding('rev', static function ($data) use (&$__keys) {
            if (array_key_exists('rev', $data)) {
                $__keys[] = 'Rev';
                return $data['rev'];
            }
        }));

        $classBindings->register(new CallbackBinding('role', static function ($data) use (&$__keys) {
            if (array_key_exists('role', $data)) {
                $__keys[] = 'Role';
                return $data['role'];
            }
        }));

        $classBindings->register(new CallbackBinding('street_address', static function ($data) use (&$__keys) {
            if (array_key_exists('street_address', $data)) {
                $__keys[] = 'StreetAddress';
                return $data['street_address'];
            }
        }));

        $classBindings->register(new CallbackBinding('tel', static function ($data) use (&$__keys) {
            if (array_key_exists('tel', $data)) {
                $__keys[] = 'Tel';
                return $data['tel'];
            }
        }));

        $classBindings->register(new CallbackBinding('url', static function ($data) use (&$__keys) {
            if (array_key_exists('url', $data)) {
                $__keys[] = 'Url';
                return $data['url'];
            }
        }));

        $classBindings->register(new CallbackBinding('__keys', static function () use (&$__keys) {
            return $__keys;
        }));
    }

    public function transforms(): string
    {
        return Customer::class;
    }
}
