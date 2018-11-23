<?php

declare(strict_types=1);

use D630\Corg\Controller\Activity\Activity as ActivityController;
use D630\Corg\Controller\Association\Association as AssociationController;
use D630\Corg\Controller\Auth\Auth as AuthController;
use D630\Corg\Controller\Customer\Customer as CustomerController;
use D630\Corg\Controller\Dashboard\Dashboard as DashboardController;
use D630\Corg\Controller\File\File as FileController;
use D630\Corg\Controller\Reference\Reference as ReferenceController;
use D630\Corg\Model\Db\Activity\Activity as ActivityModel;
use D630\Corg\Model\Db\Association\Association as AssociationModel;
use D630\Corg\Model\Db\Auth\Auth as AuthModel;
use D630\Corg\Model\Db\Customer\Customer as CustomerModel;
use D630\Corg\Model\Db\File\File as FileModel;
use D630\Corg\Model\Db\Reference\Reference as ReferenceModel;
use D630\Corg\Model\Fs\FileUpload\FileUpload as FileUploadModel;

return [
    'auth' => '/auth',
    'default' => '/',

    'routes' => [
        '/' => [
            DashboardController::class . '::do',
            [
                'Auth' => AuthModel::class . '::build',
            ],
            [
                'Html' => [
                    ':/:',
                    '/dashboard',
                ],
            ],
        ],

        '/auth' => [
            AuthController::class . '::do',
            [
                'Auth' => AuthModel::class . '::build',
            ],
        ],

        '/activities(/:activity_id)' => [
            ActivityController::class . '::do',
            [
                'Activity' => ActivityModel::class . '::build',
            ],
        ],
        '/activities/:activity_id/files' => [
            FileController::class . '::do',
            [
                'File' => FileModel::class . '::build',
                'FileUpload' => FileUploadModel::class . '::build',
            ],
            [
                'Html' => [
                    ':/activities/([0-9]{1,})/files:',
                    '/activities/\\1',
                ],
            ],
        ],
        '/activities/:activity_id/references' => [
            ReferenceController::class . '::do',
            [
                'Reference' => ReferenceModel::class . '::build',
            ],
            [
                'Html' => [
                    ':/activities/([0-9]{1,})/references:',
                    '/activities/\\1',
                ],
            ],
        ],
        '/activities/:activity_id/references/:file_id' => [
            ReferenceController::class . '::do',
            [
                'Reference' => ReferenceModel::class . '::build',
            ],
            [
                'Html' => [
                    ':/activities/([0-9]{1,})/references/([0-9]{1,}):',
                    '/activities/\\1',
                ],
            ],
        ],

        '/associations' => [
            AssociationController::class . '::do',
            [
                'Association' => AssociationModel::class . '::build',
            ],
        ],

        '/customers(/:customer_id)' => [
            CustomerController::class . '::do',
            [
                'Customer' => CustomerModel::class . '::build',
            ],
        ],
        '/customers/:customer_id/activities' => [
            ActivityController::class . '::do',
            [
                'Activity' => ActivityModel::class . '::build',
            ],
            [
                'Html' => [
                    ':/customers/([0-9]{1,})/activities:',
                    '/customers/\\1',
                ],
            ],
        ],
        '/customers/:customer_id/associations' => [
            AssociationController::class . '::do',
            [
                'Association' => AssociationModel::class . '::build',
            ],
            [
                'Html' => [
                    ':/customers/([0-9]{1,})/associations:',
                    '/customers/\\1',
                ],
            ],
        ],
        '/customers/:customer_id_1/associations/:customer_id_2' => [
            AssociationController::class . '::do',
            [
                'Association' => AssociationModel::class . '::build',
            ],
            [
                'Html' => [
                    ':/customers/([0-9]{1,})/associations/([0-9]{1,}):',
                    '/customers/\\1',
                ],
            ],
        ],
        '/customers/:customer_id/files' => [
            FileController::class . '::do',
            [
                'File' => FileModel::class . '::build',
                'FileUpload' => FileUploadModel::class . '::build',
            ],
            [
                'Html' => [
                    ':/customers/([0-9]{1,})/files:',
                    '/customers/\\1',
                ],
            ],
        ],

        '/dashboard' => [
            DashboardController::class . '::do',
            [
                'Auth' => AuthModel::class . '::build',
            ],
        ],

        '/files(/:file_id)' => [
            FileController::class . '::do',
            [
                'File' => FileModel::class . '::build',
                'FileUpload' => FileUploadModel::class . '::build',
            ],
        ],
        '/files/:file_id/activities' => [
            ActivityController::class . '::do',
            [
                'Activity' => ActivityModel::class . '::build',
            ],
            [
                'Html' => [
                    ':/files/([0-9]{1,})/activities:',
                    '/files/\\1',
                ],
            ],
        ],
        '/files/:file_id/customers' => [
            CustomerController::class . '::do',
            [
                'Customer' => CustomerModel::class . '::build',
            ],
            [
                'Html' => [
                    ':/files/([0-9]{1,})/customers:',
                    '/files/\\1',
                ],
            ],
        ],
        '/files/:file_id/references' => [
            ReferenceController::class . '::do',
            [
                'Reference' => ReferenceModel::class . '::build',
            ],
            [
                'Html' => [
                    ':/files/([0-9]{1,})/references:',
                    '/files/\\1',
                ],
            ],
        ],
        '/files/:file_id/references/:activity_id' => [
            ReferenceController::class . '::do',
            [
                'Reference' => ReferenceModel::class . '::build',
            ],
            [
                'Html' => [
                    ':/files/([0-9]{1,})/references/([0-9]{1,}):',
                    '/files/\\1',
                ],
            ],
        ],

        '/references' => [
            ReferenceController::class . '::do',
            [
                'Reference' => ReferenceModel::class . '::build',
            ],
        ],
    ],
];

    // 'default' => '/dashboard/show',

    //     '/dashboard' => [
    //         'controller' => '\D630\Corg\Controller\Dashboard',
    //         'action' => 'show',
    //     ],
