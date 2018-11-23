<?php

declare(strict_types=1);

namespace D630\Corg\Template;

use D630\Corg\Util;

class BaseTemplate
{
    private $baseFileInfo;
    private $jsFile;
    private $title;
    private $viewFileInfo;

    public function __construct(
        string $title,
        string $viewPath,
        string $baseName,
        array $jsFile = []
    ) {
        $this->title = $title;

        $this->viewFileInfo = new \SplFileInfo($viewPath);
        if (!$this->viewFileInfo->isDir() || !$this->viewFileInfo->isReadable()) {
            throw new \Exception('not a readable directory: ' . $viewPath, 500);
        }

        $this->baseFileInfo = new \SplFileInfo(
            Util::buildFilePath(
                $this->viewFileInfo->getPathname(),
                $baseName
            )
        );
        if (!$this->baseFileInfo->isFile() || !$this->baseFileInfo->isReadable()) {
            throw new \Exception(
                'not a readable file: ' . $this->baseFileInfo->getPathname(),
                500
            );
        }

        $this->jsFile = $jsFile;
    }

    final public function addJsFiles(array $f): void
    {
        $this->jsFile = array_merge($this->jsFile, $f);
    }

    final protected function getBase(): string
    {
        return $this->baseFileInfo->getPathname();
    }

    final protected function getJsFile(): array
    {
        return $this->jsFile;
    }

    final protected function getTitle(): string
    {
        return $this->title;
    }

    final protected function getViewPath(): string
    {
        return $this->viewFileInfo->getPathname();
    }
}
