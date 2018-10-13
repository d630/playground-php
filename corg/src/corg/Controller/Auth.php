<?php

namespace corg\Controller;

class Auth extends \corg\Controller
{
    private $model;
    private $config;

    public function __construct()
    {
        parent::__construct();
        $this->config = \corg\Config::get('auth');
        $this->model = new \corg\Model\Auth();
    }

    private function isSecure()
    {
        # SEE: https://stackoverflow.com/questions/5100189/use-php-to-check-if-page-was-accessed-with-ssl
        return (
            ( ! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || ( ! empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
            || ( ! empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on')
            || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
            || (isset($_SERVER['HTTP_X_FORWARDED_PORT']) && $_SERVER['HTTP_X_FORWARDED_PORT'] == 443)
            || (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https')
        );
    }

    private function filterNickname()
    {
        return filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function loginAction($options)
    {
        // if (!$this->isSecure()) {
        //     $this->error_msg[] = 'SSL/TLS required.';
        //     goto render;
        // }

        if (!empty($_POST)) {
            if ($_POST['action'] == 'sign-in') {
                if (empty($_POST['username']) || empty($_POST['password'])) {
                    $this->error_msg[] = 'need username and password.';
                    goto render;
                }
                $employee = $this->model->getEmployee($_POST['username']);
                if ($employee &&
                    password_verify($_POST['password'], $employee['password'])) {
                    $_SESSION['employee_id'] = $employee['id'];
                    $_SESSION['employee_nickname'] = $employee['nickname'];
                } else {
                    $this->error_msg[] = 'unknown user or bad password.';
                    goto render;
                }
            } elseif ($_POST['action'] == 'register') {
                // header('Location: /auth/register');
                $this->registerAction($options);
                exit;
            }
            header('Location: /dashboard');
            exit;
        }

        render:
        $this->render('index/auth/login.phtml',
            [
                'error_msg' => $this->error_msg,
                'employee' => $employee['nickname'],
                'password' => $employee['password']
            ]
        );
    }

    public function logoutAction($options)
    {
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-3600, '/' );
            $_SESSION = [];
            session_destroy();
        }

        header('Location: /');
        exit;
    }

    public function registerAction($options)
    {
        if (!empty($_POST)) {
            if ($_POST['action'] == 'register') {
                if (strcmp($this->filterNickname(), $_POST['username']) != 0) {
                    $this->error_msg[] = 'bad username';
                    goto render;
                }

                if (strlen($_POST['password']) < $this->config['pw_min_length']) {
                    $this->error_msg[] = sprintf('bad password. is less than %d characters',
                        $this->config['pw_min_length']);
                    goto render;
                }

                if (strcmp($_POST['password'], $_POST['password2']) != 0) {
                    $this->error_msg[] = 'bad passwords. not identical';
                    goto render;
                }

                if ($this->model->isNickname($_POST['username']) == 1) {
                    $this->error_msg[] = 'username already exists';
                    goto render;
                }

                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                try {
                    $this->model->beginTransaction();
                    $this->model->setEmployee($_POST['username'], $password);
                    $this->model->commit();
                } catch (\Exception $e) {
                    $this->model->rollBack();
                    throw new \Exception($e, 500);
                }
            }
            header('Location: /auth/login');
            exit;
        }

        render:
        $this->render('index/auth/register.phtml',
            [
                'error_msg' => $this->error_msg,
                'employee' => $_POST['username'],
                'password' => $_POST['password'],
                'password2' => $_POST['password2']
            ]
        );
    }
}
