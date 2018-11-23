<?php

declare(strict_types=1);

namespace D630\Corg\Controller;

class Controller implements ControllerInterface
{
    protected $models;
    protected $ns;
    protected $options;
    protected $settings;

    public function __construct(
        string $ns,
        array $models,
        array $settings,
        array $options
    ) {
        $this->ns = $ns;
        $this->models = $models;
        $this->settings = $settings;
        $this->options = $options;
    }

    public function do(): void
    {
        $factory = $this->ns . '\\Response\\ResponseFactory';
        $method = $this->settings['http_method'];
        $response = 'create' . $this->settings['http_accept'] . 'Response';

        (new $factory())
            ->{$response}($this->ns . '\\Response', $this->models, $this->settings, $this->options)
            ->{$method}();
    }
}
