<?php

declare(strict_types=1);

namespace D630\Corg\ExceptionHandler;

use D630\Corg\Config;
use D630\Corg\Template\Template;
use D630\Corg\Util;

class HtmlExceptionHandler implements ExceptionHandlerInterface
{
    private $configSite;
    private $template;

    public function __construct()
    {
        $this->configSite = Config::get('site');
        $this->template = new Template(
            $this->configSite['title'],
            $this->configSite['view_path'],
            \DIRECTORY_SEPARATOR . 'base.phtml',
            []
        );
    }

    public function respond(
        ?string $msg,
        int $code = 500,
        bool $respondMsg = false
    ): void {
        $this->template->render([
            [
                Util::buildFilePath(\DIRECTORY_SEPARATOR, 'error', "${code}.phtml"),
                null,
            ],
            [
                'title' => 'Error ' . $code,
                'statusCode' => $code,
            ],
        ]);
    }
}
