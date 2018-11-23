<?php

declare(strict_types=1);

namespace D630\Corg;

class Config
{
    public const UNIX_TIME = '1. Januar 1970 00:00:00 UTC';

    private static $dirFileInfo;

    public static function get(string $configFilename): array
    {
        $file = Util::buildFilePath(
            self::$dirFileInfo->getPathname(),
            $configFilename . '.php'
        );

        $fileInfo = new \SplFileInfo($file);

        if (!$fileInfo->isFile() || !$fileInfo->isReadable()) {
            throw new \Exception('not a readable file: ' . $file, 500);
        }

        return require $file;
    }

    public static function getDir(): string
    {
        return self::$dirFileInfo->getRealPath();
    }

    public static function setDir(string $path): void
    {
        self::$dirFileInfo = new \SplFileInfo($path);

        if (!self::$dirFileInfo->isDir() || !self::$dirFileInfo->isReadable()) {
            throw new \Exception('not a readable directory: ' . $path, 500);
        }
    }
}
