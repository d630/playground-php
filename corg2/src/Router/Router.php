<?php

declare(strict_types=1);

namespace D630\Corg\Router;

use D630\Corg\Config;
use D630\Corg\Router\Dispatcher\ClassCall;
use D630\Corg\Router\Dispatcher\DispatcherInterface;
use D630\Corg\Router\UriMatcher\Parameter;
use D630\Corg\Router\UriMatcher\Simple;
use D630\Corg\Router\UriMatcher\UriMatcherInterface;

class Router
{
    private $accept;

    private $ajax;
    private $configController;
    private $configMime;
    private $contentType;

    private $method;
    private $redirection;
    private $requestUri;

    private $route;

    public function __construct(
        string $method,
        string $requestUri,
        ?string $accept = null,
        ?string $contentType = null,
        ?string $httpXRequestedWith = null
    ) {
        $this->configController = Config::get('controller');
        $this->configMime = Config::get('mime');

        $this->method = $method;
        $this->requestUri = parse_url($requestUri, \PHP_URL_PATH);

        $this->accept = $this->parseMimeType($accept);
        if ($this->accept === '') {
            throw new \Exception('http_accept not configured.', 406);
        }

        $this->contentType = $contentType;
        if ($this->contentType !== null) {
            $this->contentType = $this->parseMimeType($contentType);
            if ($this->contentType === '') {
                throw new \Exception('content_type not configured.', 415);
            }
        }

        $this->ajax = $httpXRequestedWith !== null
            && mb_strtolower($httpXRequestedWith) === 'xmlhttprequest';
    }

    public function dispatch(): void
    {
        if ($this->route === null) {
            throw new \Exception('route does not match: ' . $this->requestUri, 400);
        } else {
            $this->route->dispatch();
        }
    }

    public function forbidIfNeeded(string $auth): void
    {
        if (empty($_SESSION['employee_id']) && $this->requestUri !== $auth) {
            header('Expires: ' . Config::UNIX_TIME);
            throw new \Exception('auth needed', 401);
        }
    }

    public function redirectIfConfigured(): void
    {
        if ($this->redirection !== null) {
            header('Expires: ' . Config::UNIX_TIME);
            // header('Content-Type: ' . . ';charset=UTF-8');
            header("Location: {$this->redirection}", true, 303);
            exit;
        }
    }

    public function setRoute(array $uriActionPairs): void
    {
        if (!\count($uriActionPairs)) {
            throw new \Exception('need uri/method pairs', 500);
        }

        foreach ($uriActionPairs as $routeUri => $routeAction) {
            if (!\count($routeAction)) {
                throw new \Exception('routeAction not configured', 500);
            }
            $this->setRouteIfMatches($this->getRoute($routeUri, $routeAction), $routeAction);
        }
    }

    private function getDispatcher(array $routeAction): DispatcherInterface
    {
        if (mb_stristr($routeAction[0], '::')) {
            return new ClassCall(
                [
                    'http_method' => mb_strtolower($this->method),
                    'http_accept' => $this->accept,
                    'http_contentType' => $this->contentType,
                    'is_ajax' => $this->ajax,
                    'for' => @$_GET['for'] ? ucfirst(mb_strtolower(
                        preg_replace('[^A-Za-z0-9 ]', '', $_GET['for'])
                    )) : null,
                ],
                $routeAction
            );
        } else {
            throw new \Exception('wrong class/method syntax', 500);
        }
    }

    private function getRedirection(?array $preg = null): ?string
    {
        if ($preg !== null && @$preg[$this->accept]) {
            return preg_replace(
                $preg[$this->accept][0],
                $preg[$this->accept][1],
                $this->requestUri
            );
        }

        return null;
    }

    private function getRoute(string $routeUri, array $routeAction): Route
    {
        return new Route(
            $this->getUriMatcher($routeUri),
            $this->getDispatcher($routeAction)
        );
    }

    private function getUriMatcher(string $routeUri): UriMatcherInterface
    {
        if (mb_stristr($routeUri, '/:') || mb_stristr($routeUri, '/(:')) {
            return new Parameter($routeUri);
        } else {
            return new Simple($routeUri);
        }
    }

    private function parseMimeType(?string $mimeType): string
    {
        if ($mimeType !== null) {
            foreach (explode(',', $mimeType) as $v) {
                $m = strtok($v, ';');
                if (!empty($this->configMime['map'][$m])) {
                    return (string) $this->configMime['map'][$m];
                }
            }
        }

        return '';
    }

    private function setRouteIfMatches(Route $route, array $routeAction): void
    {
        if ($route->matches($this->requestUri)) {
            $this->route = $route;
            $this->redirection = $this->getRedirection(@$routeAction[2]);
        }
    }
}
