<?php

declare(strict_types=1);

namespace D630\Corg\Response;

use D630\Corg\Config;

class Response
{
    protected $configResponse;
    protected $name;
    protected $options;
    protected $settings;

    public function __construct(
        string $ns,
        array $models,
        array $settings,
        array $options
    ) {
        $this->name = $this->setBaseNameSpace($ns);
        $this->setConfig();
        $this->setModels($models);
        $this->settings = $settings;
        $this->options = $options;
        $this->configResponse = Config::get('response');
    }

    public function connect(): void
    {
        throw new \Exception(
            'method not allowed for accept: '
            . "${_SERVER['REQUEST_METHOD']} => ${_SERVER['HTTP_ACCEPT']}",
            405
        );
    }

    public function delete(): void
    {
        throw new \Exception(
            'method not allowed for accept: '
            . "${_SERVER['REQUEST_METHOD']} => ${_SERVER['HTTP_ACCEPT']}",
            405
        );
    }

    public function get(): void
    {
        throw new \Exception(
            'method not allowed for accept: '
            . "${_SERVER['REQUEST_METHOD']} => ${_SERVER['HTTP_ACCEPT']}",
            405
        );
    }

    public function head(): void
    {
        throw new \Exception(
            'method not allowed for accept: '
            . "${_SERVER['REQUEST_METHOD']} => ${_SERVER['HTTP_ACCEPT']}",
            405
        );
    }

    public function options(): void
    {
        throw new \Exception(
            'method not allowed for accept: '
            . "${_SERVER['REQUEST_METHOD']} => ${_SERVER['HTTP_ACCEPT']}",
            405
        );
    }

    public function post(): void
    {
        throw new \Exception(
            'method not allowed for accept: '
            . "${_SERVER['REQUEST_METHOD']} => ${_SERVER['HTTP_ACCEPT']}",
            405
        );
    }

    public function put(): void
    {
        throw new \Exception(
            'method not allowed for accept: '
            . "${_SERVER['REQUEST_METHOD']} => ${_SERVER['HTTP_ACCEPT']}",
            405
        );
    }

    public function trace(): void
    {
        throw new \Exception(
            'method not allowed for accept: '
            . "${_SERVER['REQUEST_METHOD']} => ${_SERVER['HTTP_ACCEPT']}",
            405
        );
    }

    private function setBaseNameSpace(string $ns): string
    {
        // TODO
        // Corg\Controller\Customer\Response => Customer

        return mb_substr(
            mb_strrchr(
                mb_substr(
                    $ns,
                    0,
                    mb_strrpos($ns, '\\')
                ),
                '\\'
            ),
            1
        );
    }

    private function setConfig(): void
    {
        $conf = Config::get('controller');
        if (!@$conf['config'][$this->name]) {
            return;
        }

        foreach ($conf['config'][$this->name] as $k => $v) {
            $k = 'config' . $k;
            // crazy
            $this->{$k} = $v;
        }
    }

    private function setModels(array $models): void
    {
        if (!\count($models)) {
            return;
        }

        foreach ($models as $k => $v) {
            $k = 'model' . $k;
            // crazy
            $this->{$k} = $v;
        }
    }
}
