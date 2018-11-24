<?php

declare(strict_types=1);

namespace D630\Corg\Controller\Customer\Response;

use D630\Corg\Entity\Customer;
use D630\Corg\Entity\CustomerTransformer;
use D630\Corg\MyException;
use D630\Corg\Response\JsonResponse as PJsonResponse;
use Karriere\JsonDecoder\JsonDecoder;

class JsonResponse extends PJsonResponse implements JsonResponseInterface
{
    private const HEADER_ALLOW = 'Allow: GET, POST, DELETE, PUT';

    public function __construct(array $models, array $settings, array $options)
    {
        parent::__construct(__NAMESPACE__, $models, $settings, $options);
    }

    public function connect(): void
    {
        header(self::HEADER_ALLOW);
        parent::connect();
    }

    public function delete(): void
    {
        try {
            $this->modelCustomer->beginTransaction();
            if (!empty($this->options['file_id'])) {
                $this->options['file_id'] = $this->options['file_id'] ?? 0;
                if ($this->options['file_id'] > 0) {
                    $this->modelCustomer->unsetAllFilesCustomers($this->options['file_id']);
                } else {
                    throw new MyException('invalid id', 400, false);
                }
            } else {
                $this->options['customer_id'] = $this->options['customer_id'] ?? 0;
                if ($this->options['customer_id'] > 0) {
                    $this->modelCustomer->unsetCustomer($this->options['customer_id']);
                } else {
                    $this->modelCustomer->unsetAllCustomers();
                }
            }
            $this->modelCustomer->commit();
        } catch (\Exception $e) {
            $this->modelCustomer->rollBack();
            throw new \Exception(
                $e->getMessage(),
                method_exists($e, 'chooseCode') ? $e->chooseCode(500, 400) : 500
            );
        }

        // $o = null;
        // try {
        //     $o = $this->modelFile->getOrphans();
        //     $this->modelFile->beginTransaction();
        //     $this->modelFile->unsetOrphans();
        //     $this->modelFile->commit();
        // } catch (\Exception $e) {
        //     $this->modelFile->rollBack();
        //     throw new \Exception($e->getMessage(), 500);
        // }

        // foreach ($o as $k) {
        //     if (is_numeric($k) && is_writable($configFile['upload_dir'] . $k)) {
        //         unlink($configFile['upload_dir'] . $k);
        //     }
        // }

        $this->respond(204);
    }

    public function get(): void
    {
        if (!empty($this->options['file_id'])) {
            $this->options['file_id'] = $this->options['file_id'] ?? 0;
            if ($this->options['file_id'] > 0) {
                $this->respond(
                    200,
                    $this->modelCustomer
                        ->getAllFilesCustomers($this->options['file_id'])
                );
            } else {
                throw new \Exception('invalid id', 400);
            }
        } else {
            $this->options['customer_id'] = $this->options['customer_id'] ?? 0;
            if ($this->options['customer_id'] > 0) {
                $this->respond(
                    200,
                    Customer::get($this->options['customer_id'], $this->modelCustomer)
                );
            } else {
                $this->respond(
                    200,
                    $this->modelCustomer->getAllCustomers()
                );
            }
        }
    }

    public function head(): void
    {
        header(self::HEADER_ALLOW);
        parent::head();
    }

    public function options(): void
    {
        header(self::HEADER_ALLOW);
        parent::options();
    }

    public function post(): void
    {
        $customers = $this->readMultipleInFromBody(
            new JsonDecoder(true),
            Customer::class
        );

        // $oldCustomerId = $this->modelCustomer->getLastCustomerId();
        $customers[0]->postMultiple($customers, $this->modelCustomer);
        $newCustomerId = $this->modelCustomer->getEmployeesLastCustomerId($_SESSION['employee_id']);

        // if ($newCustomerId === $oldCustomerId) {
        //     $this->respond(500);
        // } else {
        $this->respond(201, Customer::get($newCustomerId, $this->modelCustomer));
        // }
    }

    public function put(): void
    {
        $this->options['customer_id'] = $this->options['customer_id'] ?? 0;
        if ($this->options['customer_id'] < 1) {
            throw new \Exception('need valid id', 400);
        }

        $oldCustomer = Customer::get($this->options['customer_id'], $this->modelCustomer);

        if (!$oldCustomer[0]) {
            throw new \Exception('customer not found', 404);
        }

        $oldCustomer[0]->assignProps(
            $this->readInFromBody(
                new JsonDecoder(true),
                Customer::class,
                new CustomerTransformer()
            )
        );

        $oldCustomer[0]->put($this->modelCustomer);

        $this->respond(201, Customer::get($this->options['customer_id'], $this->modelCustomer));
    }

    public function trace(): void
    {
        header(self::HEADER_ALLOW);
        parent::trace();
    }
}
