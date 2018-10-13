<?php

namespace corg;

class Router
{
    private $config;

    public function __construct()
    {
        $this->config = \corg\Config::get('routes');
    }

    private function call($options)
    {
        $controller = $options['controller'];
        $action = $options['action'];
        unset($options['controller'], $options['action']);

        if (! class_exists($controller)) {
            $this->error('controller does not exist: ' . $controller, 404);
        }

        if (! method_exists($controller, $action . 'Action')) {
            $this->error('method does not exist: ' . $action, 400);
        }

        $callable = [$controller, $action . 'Action'];
        if (! is_callable($callable)) {
            $this->error('method not callable: ' . $action, 500);
        }

        $callable = [new $controller, $action . 'Action'];
        return $callable($options);
    }

    public function start($route)
    {
        if (empty($route) || $route == '/') {
            if (isset($this->config['default'])) {
                $route = $this->config['default'];
            } else {
                $this->error('default site not configured.', 404);
            }
        }

        foreach ($this->config['routes'] as $path => $defaults) {
            // SEE http://php.net/manual/de/regexp.reference.subpatterns.php
            $regex = '@' . preg_replace(
                '@:([\w]+)@',
                '(?P<$1>[^/]+)',
                str_replace(')', ')?', (string) $path)
            ) . '@';
            $matches = [];
            if (preg_match($regex, $route, $matches)) {
                $options = $defaults;
                foreach ($matches as $key => $value) {
                    if (is_numeric($key)) {
                        continue;
                    }
                    $options[$key] = $value;
                }
                if (isset($options['controller']) && isset($options['action'])) {
                    return $this->call($options);
                }
                $this->error('route configured?', 404);
            }
        }
        $this->error('route not configured.', 404);
    }

    private function error($msg, $code)
    {
        throw new \Exception($msg, $code);
    }
}
