<?php

declare(strict_types=1);

namespace D630\Corg\Controller\Auth;

use D630\Corg\Controller\Controller;

class Auth extends Controller
{
    public function __construct(
        array $models,
        array $settings,
        array $options
    ) {
        parent::__construct(__NAMESPACE__, $models, $settings, $options);
    }
}
