<?php

declare(strict_types=1);

namespace D630\Corg;

class Util
{
    public static function buildFilePath(string ...$elements): string
    {
        return implode(\DIRECTORY_SEPARATOR, $elements);
    }
}
