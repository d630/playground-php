<?php

declare(strict_types=1);

namespace D630\Corg\Response;

use D630\Corg\Config;
use D630\Corg\Template\Template;

class HtmlResponse extends Response
{
    protected $configSite;
    protected $template;

    public function __construct(
        string $ns,
        array $models,
        array $settings,
        array $options
    ) {
        parent::__construct($ns, $models, $settings, $options);
        $this->configSite = Config::get('site');
        $this->template = new Template(
            $this->configSite['title'],
            $this->configSite['view_path'],
            \DIRECTORY_SEPARATOR . 'base.phtml',
            []
        );
        $this->addJsFiles($this->configSite[$this->name]['jsFiles']);
    }

    public function connect(): void
    {
        header('Allow: GET');
        parent::connect();
    }

    public function delete(): void
    {
        header('Allow: GET');
        parent::delete();
    }

    public function get(): void
    {
        $this->render([
            $this->configSite[$this->name]['renderFiles'],
            [
                'statusCode' => 200,
            ],
        ]);
    }

    public function head(): void
    {
        header('Allow: GET');
        parent::head();
    }

    public function options(): void
    {
        header('Allow: GET');
        parent::options();
    }

    public function post(): void
    {
        header('Allow: GET');
        parent::post();
    }

    public function put(): void
    {
        header('Allow: GET');
        parent::put();
    }

    public function trace(): void
    {
        header('Allow: GET');
        parent::trace();
    }

    private function addJsFiles(array $f): void
    {
        $this->template->addJsFiles($f);
    }

    private function render(array $array): void
    {
        $this->template->render($array);
    }
}
