<?php

declare(strict_types=1);

use D630\Corg\Util;

return [
    'title' => 'corg',
    'view_path' => realpath(Util::buildFilePath('..', 'views')),

    'Activity' => [
        'jsFiles' => [
            '/js/activity/activity.js',
            '/js/activity/fetch.js',
            '/js/activity/remove.js',
            '/js/activity/add.js',
        ],
        'renderFiles' => [
            Util::buildFilePath(\DIRECTORY_SEPARATOR, 'index', 'activity', 'nav.phtml'),
            Util::buildFilePath(\DIRECTORY_SEPARATOR, 'index', 'activity', 'main.phtml'),
        ],
    ],

    'Auth' => [
        'jsFiles' => [
            '/js/auth/auth.js',
        ],
        'renderFiles' => [
            Util::buildFilePath(\DIRECTORY_SEPARATOR, 'index', 'auth', 'nav.phtml'),
            Util::buildFilePath(\DIRECTORY_SEPARATOR, 'index', 'auth', 'main.phtml'),
        ],
    ],

    'Customer' => [
        'jsFiles' => [
            '/js/customer/customer.js',
            '/js/customer/fetch.js',
            '/js/customer/remove.js',
            '/js/customer/edit.js',
            '/js/customer/add.js',
            '/js/customer/export.js',
        ],
        'renderFiles' => [
            Util::buildFilePath(\DIRECTORY_SEPARATOR, 'index', 'customer', 'nav.phtml'),
            Util::buildFilePath(\DIRECTORY_SEPARATOR, 'index', 'customer', 'main.phtml'),
        ],
    ],

    'Dashboard' => [
        'jsFiles' => [
            '/js/dashboard/dashboard.js',
        ],
        'renderFiles' => [
            Util::buildFilePath(\DIRECTORY_SEPARATOR, 'index', 'dashboard', 'nav.phtml'),
            Util::buildFilePath(\DIRECTORY_SEPARATOR, 'index', 'dashboard', 'main.phtml'),
        ],
    ],

    'File' => [
        'jsFiles' => [
            '/js/file/file.js',
            '/js/file/fetch.js',
            '/js/file/remove.js',
            '/js/file/add.js',
            '/js/file/download.js',
        ],
        'renderFiles' => [
            Util::buildFilePath(\DIRECTORY_SEPARATOR, 'index', 'file', 'nav.phtml'),
            Util::buildFilePath(\DIRECTORY_SEPARATOR, 'index', 'file', 'main.phtml'),
        ],
    ],
];
