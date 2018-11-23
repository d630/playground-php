<?php

declare(strict_types=1);

namespace D630\Corg\Controller\Auth\Response;

use D630\Corg\Entity\Auth;
use D630\Corg\Entity\AuthTransformer;
use D630\Corg\Response\JsonResponse as PJsonResponse;
use Karriere\JsonDecoder\JsonDecoder;

class JsonResponse extends PJsonResponse implements JsonResponseInterface
{
    private const HEADER_ALLOW = 'Allow: POST, PUT, DELETE';

    public function __construct(array $models, array $settings, array $options)
    {
        parent::__construct(__NAMESPACE__, $models, $settings, $options);
    }

    public function connect(): void
    {
        header(self::HEADER_ALLOW);
        parent::connect();
    }

    public function delete(): void
    {
        if (empty($_SESSION['employee_id'])) {
            throw new \Exception('logout not allowed, when not logged in', 400);
        }

        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
            $_SESSION = [];
            session_destroy();
        }

        $this->respond(204);
    }

    public function get(): void
    {
        header(self::HEADER_ALLOW);
        throw new \Exception(
            'method not allowed for accept: '
            . "${_SERVER['REQUEST_METHOD']} => ${_SERVER['HTTP_ACCEPT']}",
            405
        );
    }

    public function head(): void
    {
        header(self::HEADER_ALLOW);
        parent::head();
    }

    public function options(): void
    {
        header(self::HEADER_ALLOW);
        parent::options();
    }

    public function post(): void
    {
        if (!empty($_SESSION['employee_id'])) {
            throw new \Exception('already logged in', 400);
        }

        $auth = $this->readInFromBody(
            new JsonDecoder(true),
            Auth::class
        );

        $employee = Auth::get($auth->getNickname(), $this->modelAuth);
        if ($employee[0] &&
            password_verify($auth->getPassword(), $employee[0]->getPassword())
        ) {
            $_SESSION['employee_id'] = $employee[0]->getId();
            $_SESSION['employee_nickname'] = $employee[0]->getNickname();
        } else {
            throw new \Exception('invalid username or password', 400);
        }

        $employee[0]->setPassword('');

        $this->respond(201, $employee);
    }

    public function put(): void
    {
        if (!empty($_SESSION['employee_id'])) {
            throw new \Exception('registration not allowed, when already logged in', 400);
        }

        $auth = $this->readInFromBody(
            new JsonDecoder(true),
            Auth::class,
            new AuthTransformer()
        );

        $employee = Auth::get($auth->getNickname(), $this->modelAuth);
        if ($employee[0]) {
            throw new \Exception('username already exist', 400);
        }

        $password = $auth->getPassword();

        if (\mb_strlen($password) < $this->configAuth['pw_min_length'] ||
            \mb_strlen($password) > $this->configAuth['pw_max_length']
        ) {
            throw new \Exception('invalid password length', 400);
        }

        $auth->setPassword(password_hash($password, \PASSWORD_DEFAULT));
        $auth->post($this->modelAuth);

        $employee = Auth::get($auth->getNickname(), $this->modelAuth);
        $employee[0]->setPassword('');

        $this->respond(201, $employee);
    }

    public function trace(): void
    {
        header(self::HEADER_ALLOW);
        parent::trace();
    }
}
