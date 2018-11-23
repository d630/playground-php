<?php

declare(strict_types=1);

namespace D630\Corg\Template;

use D630\Corg\Config;

class Template extends BaseTemplate
{
    protected $configResponse;
    private $mainLeftCol;
    private $mainRightCol;

    public function __construct(
        string $title,
        string $viewPath,
        string $baseName,
        array $jsFile = []
    ) {
        parent::__construct($title, $viewPath, $baseName, $jsFile);
        $this->configResponse = Config::get('response');
    }

    public function __call(string $method, array $argv = []): void
    {
        if ($method === 'render') {
            switch (\count($argv[0])) {
                case 0:
                case 1:
                    @$this->setProps($argv[0][0]);
                    $this->renderBase();
                    break;
                case 2:
                    $this->setProps($argv[0][1]);
                    $this->mainLeftCol = parent::getViewPath() . $argv[0][0][0];
                    $this->mainRightCol = parent::getViewPath() . $argv[0][0][1];
                    $this->renderBase();
            }
        }
    }

    public function content(string $page): void
    {
        $pageInfo = [
            new \SplFileInfo($page),
            new \SplFileInfo(parent::getViewPath() . $page),
        ];

        foreach ($pageInfo as $info) {
            if ($info->isFile() && $info->isReadable()) {
                require $info->getPathname();
                break;
            }
        }
    }

    public function includeStatusCode(int $code = 500): void
    {
        $func = $this->configResponse['status'][$code] ?? @$this->configResponse['status'][500];
        $func();
    }

    private function renderBase(): void
    {
        require parent::getBase();
    }

    private function setProps(array $data = []): void
    {
        foreach ($data as $k => $v) {
            // crazy
            $this->{$k} = $v;
        }
    }
}
