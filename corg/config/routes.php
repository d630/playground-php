<?php

return [
    'default' => '/dashboard/show',

    'routes' => [
        '/customer/dissociate(/:customer_id_1)' => [
            'controller' => '\corg\Controller\Customer',
            'action' => 'dissociate',
        ],
        '/customer/associate(/:customer_id_1)' => [
            'controller' => '\corg\Controller\Customer',
            'action' => 'associate',
        ],
        '/customer/list(/:id)' => [
            'controller' => '\corg\Controller\Customer',
            'action' => 'list',
        ],
        '/customer/add(/:id)' => [
            'controller' => '\corg\Controller\Customer',
            'action' => 'add',
        ],
        '/customer/delete(/:id)' => [
            'controller' => '\corg\Controller\Customer',
            'action' => 'delete',
        ],
        '/customer/export(/:id)' => [
            'controller' => '\corg\Controller\Customer',
            'action' => 'export',
        ],
        '/customer/edit/:id' => [
            'controller' => '\corg\Controller\Customer',
            'action' => 'edit',
        ],

        '/activity/list(/:id)' => [
            'controller' => '\corg\Controller\Activity',
            'action' => 'list',
        ],
        '/activity/add(/:customer_id)' => [
            'controller' => '\corg\Controller\Activity',
            'action' => 'add',
        ],
        '/activity/delete(/:id)' => [
            'controller' => '\corg\Controller\Activity',
            'action' => 'delete',
        ],

        '/files/download(/:download_file_id)' => [
            'controller' => '\corg\Controller\Files',
            'action' => 'download',
        ],
        '/files/dereference(/:file_id)' => [
            'controller' => '\corg\Controller\Files',
            'action' => 'dereference',
        ],
        '/files/reference(/:file_id)' => [
            'controller' => '\corg\Controller\Files',
            'action' => 'reference',
        ],
        '/files/add(/:activity_id)' => [
            'controller' => '\corg\Controller\Files',
            'action' => 'add',
        ],
        '/files/delete(/:id)' => [
            'controller' => '\corg\Controller\Files',
            'action' => 'delete',
        ],
        '/files/list(/:id)' => [
            'controller' => '\corg\Controller\Files',
            'action' => 'list',
        ],

        '/dashboard' => [
            'controller' => '\corg\Controller\Dashboard',
            'action' => 'show',
        ],

        '/auth/logout' => [
            'controller' => '\corg\Controller\Auth',
            'action' => 'logout',
        ],
        '/auth/login' => [
            'controller' => '\corg\Controller\Auth',
            'action' => 'login',
        ],
        '/auth/register' => [
            'controller' => '\corg\Controller\Auth',
            'action' => 'register',
        ]
    ]
];
