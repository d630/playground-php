<?php

namespace corg\Controller;

class Activity extends \corg\Controller
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new \corg\Model\Activity();
    }

    public function listAction($options)
    {
        $id = $options['id'] ?? null;

        $this->render('index/activity/list.phtml',
            [
                'id' => $id,
                'activities' => $this->model->getAllActivitiesTiny(),
                'activity' => $this->model->getActivity($id),
                'error_msg' => $this->error_msg,

                'files' => (new \corg\Model\Files())->getFiles($id)
            ]
        );
    }

    public function addAction($options)
    {
        $customers = (new \corg\Model\Customer())->getAllCustomersTiny();

        $customer_id = null;
        if (!empty($options['customer_id'])) {
            $customer_id = $options['customer_id'];
        }

        if (!empty($_POST)) {
            if ($_POST['action'] == 'ok') {
                try {
                    $this->model->beginTransaction();
                    $this->model->setActivity(
                        $_POST['name'],
                        $_POST['description'],
                        $_POST['customer_id'],
                        $_POST['employee_id']
                    );
                    $this->model->commit();
                } catch (\Exception $e) {
                    $this->model->rollBack();
                    throw new \Exception($e, 500);
                }
            }
            header('Location: /activity/list/' . $this->model->getLastActivityId());
            exit;
        }

        $this->render('index/activity/add.phtml',
            [
                'error_msg' => $this->error_msg,
                'customer_id' => $customer_id,
                'customers' => $customers
            ]
        );
    }

    public function deleteAction($options)
    {
        if (empty($options['id'])) {
            $this->error_msg[] = 'need an id.';
            $this->listAction(null);
        } else {
            $modelFile = new \corg\Model\Files();
            try {
                $this->model->beginTransaction();
                $this->model->unsetActivity($options['id']);
                $modelFile->unsetOrphans();
                $this->model->commit();
            } catch (\Exception $e) {
                $this->model->rollBack();
                throw new \Exception($e, 500);
            }
            header('Location: /activity/list/' . $this->model->getLastActivityId());
        }

        exit;
    }
}
