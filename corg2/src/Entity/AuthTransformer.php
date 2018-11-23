<?php

declare(strict_types=1);

namespace D630\Corg\Entity;

use Karriere\JsonDecoder\Bindings\CallbackBinding;
use Karriere\JsonDecoder\ClassBindings;
use Karriere\JsonDecoder\Transformer;

class AuthTransformer implements Transformer
{
    public function register(ClassBindings $classBindings): void
    {
        $classBindings->register(new CallbackBinding('nickname', static function ($data) {
            if (!array_key_exists('nickname', $data)) {
                throw new \Exception('nickname missing', 400);
            }

            $nickname = preg_replace('[^A-Za-z0-9 ]', '', $data['nickname']);

            if (strcmp($nickname, (string) $data['nickname']) !== 0) {
                throw new \Exception('invalid username', 400);
            }

            return $nickname;
        }));

        $classBindings->register(new CallbackBinding('password', static function ($data) {
            if (!array_key_exists('password', $data)) {
                throw new \Exception('password missing', 400);
            }

            $password = filter_var($data['password'], \FILTER_SANITIZE_EMAIL);

            if (strcmp($password, (string) $data['password']) !== 0) {
                throw new \Exception('invalid password', 400);
            }

            if (strcmp($password, (string) @$data['password2']) !== 0) {
                throw new \Exception('password2 and password not identical', 400);
            }

            return $password;
        }));
    }

    public function transforms(): string
    {
        return Auth::class;
    }
}
