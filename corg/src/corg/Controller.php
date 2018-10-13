<?php

namespace corg;

class Controller
{
    private $config;
    protected $template;
    protected $error_msg = [];
    protected $_post = [];

    public function __construct()
    {
        $this->config = \corg\Config::get('site');
        $this->template = new \corg\Template(
            $this->config['view_path'] . '/base.phtml'
        );
    }

    protected function render($template, $data = [])
    {
        $this->template
             ->render($this->config['view_path'] . '/' . $template, $data);
    }
}
