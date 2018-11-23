<?php

declare(strict_types=1);

namespace D630\Corg\Export;

use D630\Corg\Entity\Customer;

interface ExporterInterface
{
    public function convert(Customer $customer): void;
}
