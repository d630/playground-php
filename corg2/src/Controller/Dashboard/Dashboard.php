<?php

declare(strict_types=1);

namespace D630\Corg\Controller\Dashboard;

use D630\Corg\Controller\Controller;

class Dashboard extends Controller
{
    public function __construct(
        array $models,
        array $settings,
        array $options
    ) {
        parent::__construct(__NAMESPACE__, $models, $settings, $options);
    }
}
