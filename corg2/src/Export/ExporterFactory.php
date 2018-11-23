<?php

declare(strict_types=1);

namespace D630\Corg\Export;

class ExporterFactory
{
    public function createVcardExporter(): ExporterInterface
    {
        return new VcardExporter();
    }
}
