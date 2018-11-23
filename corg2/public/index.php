<?php

declare(strict_types=1);

session_start(
    [
        'name' => 'corg',
        'cookie_lifetime' => 3600
    ]
);

// private function isSecure()
// {
//     # SEE: https://stackoverflow.com/questions/5100189/use-php-to-check-if-page-was-accessed-with-ssl
//     return (
//         (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
//         || (! empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
//         || (! empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on')
//         || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
//         || (isset($_SERVER['HTTP_X_FORWARDED_PORT']) && $_SERVER['HTTP_X_FORWARDED_PORT'] == 443)
//         || (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] == 'https')
//     );
// }

require_once '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';

use D630\Corg\Config;
use D630\Corg\ExceptionHandler\ExceptionHandler;
use D630\Corg\Router\Router;
use D630\Corg\Util;

Config::setDir(Util::buildFilePath('..', 'config'));

(new ExceptionHandler(@$_SERVER['HTTP_ACCEPT']))
    ->register();

$configRoutes = Config::get('routes');
$router = new Router(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI'],
    @$_SERVER['HTTP_ACCEPT'],
    @$_SERVER['HTTP_CONTENT_TYPE'],
    @$_SERVER['HTTP_X_REQUESTED_WITH']
);
$router
    ->setRoute($configRoutes['routes']);
$router
    ->forbidIfNeeded($configRoutes['auth']);
$router
    ->redirectIfConfigured();
$router
    ->dispatch();
