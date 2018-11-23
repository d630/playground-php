<?php

declare(strict_types=1);

namespace D630\Corg\Model\Fs\FileUpload\Request;

use D630\Corg\Request\StandardRequestInterface as PStandardRequestInterface;

interface StandardRequestInterface extends PStandardRequestInterface
{
    public function checkTmpName(?string $tmpName = null): string;

    public function emptyUploadDir(): void;

    public function getUploadDir(): string;

    public function processUpload(): int;

    public function rename(string $s1, int $s2): void;

    public function unlink(int $f): void;

    public function unlinkArray(array $arr = []): void;
}
