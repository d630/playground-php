<?php

namespace corg\Controller;

class Customer extends \corg\Controller
{
    private $model; public function __construct()
    {
        parent::__construct();
        $this->model = new \corg\Model\Customer();
    }

    public function listAction($options)
    {
        $id = $options['id'] ?? null;

        $this->render('index/customer/list.phtml',
            [
                'id' => $id,
                'customers' => $this->model->getAllCustomersTiny(),
                'customer' => $this->model->getCustomer($id),
                'associations' => $this->model->getAssociations($id),
                'error_msg' => $this->error_msg,

                'activities' => (new \corg\Model\Activity())->getActivities($id)
            ]
        );
    }

    public function addAction($options)
    {
        $this->_post = [
            'family_name' => null,
            'given_name' => null,
            'additional_name' => null,
            'honorific_prefix' => null,
            'honorific_suffix' => null,
            'role' => null,
            'org' => null,
            'post_office_box' => null,
            'street_address' => null,
            'extended_address' => null,
            'locality' => null,
            'region' => null,
            'postal_code' => null,
            'country_name' => null,
            'tel' => null,
            'email' => null,
            'url' => null,
            'employee_id' => null
        ];

        if (!empty($_POST)) {
            if ($_POST['action'] == 'ok') {
                $customers = $this->model->getAllCustomersTinyFlip();
                if (isset($customers[$_POST['org']])) {
                    $this->error_msg[] = 'org already exists. Choose an unique name.';
                    $this->_post = array_replace($this->_post, $_POST);
                    goto render;
                }
                try {
                    $this->model->beginTransaction();
                    $this->model->setCustomer(
                        $_POST['family_name'],
                        $_POST['given_name'],
                        $_POST['additional_name'],
                        $_POST['honorific_prefix'],
                        $_POST['honorific_suffix'],
                        $_POST['role'],
                        $_POST['org'],
                        $_POST['post_office_box'],
                        $_POST['street_address'],
                        $_POST['extended_address'],
                        $_POST['locality'],
                        $_POST['region'],
                        $_POST['postal_code'],
                        $_POST['country_name'],
                        $_POST['tel'],
                        $_POST['email'],
                        $_POST['url'],
                        $_POST['employee_id']
                    );
                    $this->model->commit();
                } catch (\Exception $e) {
                    $this->model->rollBack();
                    throw new \Exception($e, 500);
                }
            }
            header('Location: /customer/list/' . $this->model->getLastCustomerId());
            exit;
        }

        render:
        $this->render('index/customer/add.phtml',
            [
                'error_msg' => $this->error_msg,
                '_post' => $this->_post
            ]
        );
    }

    public function associateAction($options)
    {
        if (empty($options['customer_id_1'])) {
            $this->error_msg[] = 'need customer 1.';
            $options['customer_id_1'] = null;
        }

        $customers = $this->model->getAbleToAssociateDirty($options['customer_id_1']);
        $customer_org_1 = $customers[$options['customer_id_1']] ?? null;
        unset($customers[$options['customer_id_1']]);

        if (!empty($_POST)) {
            if ($_POST['action'] == 'ok') {
                try {
                    $this->model->beginTransaction();
                    $this->model->setAssociation(
                        $_POST['customer_id_1'],
                        $_POST['customer_id_2']
                    );
                    $this->model->commit();
                } catch (\Exception $e) {
                    $this->model->rollBack();
                    throw new \Exception($e, 500);
                }
            }
            header('Location: /customer/list/' . $_POST['customer_id_1']);
            exit;
        }

        $this->render('index/customer/associate.phtml',
            [
                'error_msg' => $this->error_msg,
                'customers' => $customers,
                'customer_id_1' => $options['customer_id_1'],
                'customer_org_1' => $customer_org_1
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
                $this->model->unsetCustomer($options['id']);
                $modelFile->unsetOrphans();
                $this->model->commit();
            } catch (\Exception $e) {
                $this->model->rollBack();
                throw new \Exception($e, 500);
            }
            header('Location: /customer/list/' . $this->model->getLastCustomerId());
        }

        exit;
    }

    public function dissociateAction($options)
    {
        $customers = $this->model->getAllCustomersTiny();

        if (!empty($_POST)) {
            if ($_POST['action'] == 'ok') {
                if (empty($_POST['customer_id_1'])) {
                    $this->error_msg[] = 'need an org.';
                    goto render;
                }
                if (empty($_POST['ids'])) {
                    $this->error_msg[] = 'check in an org.';
                    goto render;
                }
                try {
                    $this->model->beginTransaction();
                    foreach ($_POST['ids'] as $id) {
                        $this->model->unsetAssociation(
                            $_POST['customer_id_1'],
                            $id
                        );
                    }
                    $this->model->commit();
                } catch (\Exception $e) {
                    $this->model->rollBack();
                    throw new \Exception($e, 500);
                }
            }
            header('Location: /customer/list/' . $_POST['customer_id_1']);
            exit;
        }

        render:
        $this->render('index/customer/dissociate.phtml',
            [
                'error_msg' => $this->error_msg,
                'associations' => $this->model->getAssociations($options['customer_id_1']),
                'customer_id_1' => $options['customer_id_1'],
                'customer_org_1' => $customers[$options['customer_id_1']]
            ]
        );
    }

    public function exportAction($options)
    {
        if (isset($options['id'])) {
            $exporter = (new \corg\Export\ExporterFactory())->createVcardExporter();
            $exporter->convert($this->model->getCustomer($options['id']));
            $exporter->download();
        } else {
            $this->error_msg[] = 'need an id.';
            $this->listAction($options);
        }
    }

    public function editAction($options)
    {
        if (empty($options['id'])) {
            $this->error_msg[] = 'need customer id.';
            goto render;
        }

        $this->_post = $this->model->getCustomer($options['id']);

        if (!empty($_POST)) {
            if ($_POST['action'] == 'ok') {
                try {
                    $this->model->beginTransaction();
                    $this->model->resetCustomer(
                        $_POST['family_name'],
                        $_POST['given_name'],
                        $_POST['additional_name'],
                        $_POST['honorific_prefix'],
                        $_POST['honorific_suffix'],
                        $_POST['role'],
                        $_POST['post_office_box'],
                        $_POST['street_address'],
                        $_POST['extended_address'],
                        $_POST['locality'],
                        $_POST['region'],
                        $_POST['postal_code'],
                        $_POST['country_name'],
                        $_POST['tel'],
                        $_POST['email'],
                        $_POST['url']
                    );
                    $this->model->commit();
                } catch (\Exception $e) {
                    $this->model->rollBack();
                    throw new \Exception($e, 500);
                }
            }
            header('Location: /customer/list/' . $options['id']);
            exit;
        }

        render:
        $this->render('index/customer/edit.phtml',
            [
                'error_msg' => $this->error_msg,
                '_post' => $this->_post
            ]
        );
    }
}
