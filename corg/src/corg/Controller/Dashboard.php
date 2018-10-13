<?php

namespace corg\Controller;

class Dashboard extends \corg\Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function showAction($options)
    {
        $this->render('index/dashboard/show.phtml',
            [
                'customers' => (new \corg\Model\Customer())->getAllCustomersShort(),
                'activities' => (new \corg\Model\Activity())->getAllActivitiesShort(),
                'files' => (new \corg\Model\Files())->getAllFilesShort()
            ]
        );
    }
}
