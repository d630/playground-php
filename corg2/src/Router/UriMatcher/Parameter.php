<?php

declare(strict_types=1);

namespace D630\Corg\Router\UriMatcher;

class Parameter implements UriMatcherInterface
{
    private $requestUri;
    private $routeUri;

    public function __construct(string $routeUri)
    {
        $this->routeUri = rtrim($routeUri, '/');
    }

    public function getParameters(): array
    {
        $matches = [];
        preg_match(
            $this->getRouteRegEx(),
            $this->requestUri,
            $matches
        );

        $params = [];
        foreach ($matches as $k => $v) {
            if (is_numeric($k)) {
                continue;
            }
            if (!is_numeric($v)) {
                throw new \Exception(
                    sprintf(
                        "parameter is not numeric: \$params[%s]=%s\n",
                        $k,
                        $v
                    ),
                    400
                );
            }
            $params[$k] = (int) $v;
        }

        return $params;
    }

    public function matches(string $requestUri): bool
    {
        $this->requestUri = rtrim($requestUri, '/');

        return (bool) preg_match($this->getRouteRegEx(), $this->requestUri);
    }

    private function getRouteRegEx(): string
    {
        // SEE http://php.net/manual/de/regexp.reference.subpatterns.php
        return '@^' . preg_replace(
            '@:([\w]+)@',
            '(?P<$1>[^/]+)',
            str_replace(')', ')?', $this->routeUri)
        ) . '$@u';
    }
}
