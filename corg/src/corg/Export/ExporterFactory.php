<?php

namespace corg\Export;

class ExporterFactory
{
    public function createVcardExporter()
    {
        return new VcardExporter();
    }
}
