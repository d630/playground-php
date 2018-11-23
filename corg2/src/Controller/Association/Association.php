<?php

declare(strict_types=1);

namespace D630\Corg\Controller\Association;

use D630\Corg\Controller\Controller;

class Association extends Controller
{
    public function __construct(
        array $models,
        array $settings,
        array $options
    ) {
        parent::__construct(__NAMESPACE__, $models, $settings, $options);
    }
}
