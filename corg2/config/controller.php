<?php

declare(strict_types=1);

use D630\Corg\Config;

return [
    'config' => [
        'Auth' => [
            'Auth' => Config::get('auth'),
        ],
    ],
];
