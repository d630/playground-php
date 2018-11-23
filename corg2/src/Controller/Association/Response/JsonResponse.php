<?php

declare(strict_types=1);

namespace D630\Corg\Controller\Association\Response;

use D630\Corg\MyException;
use D630\Corg\Response\JsonResponse as PJsonResponse;

class JsonResponse extends PJsonResponse implements JsonResponseInterface
{
    private const HEADER_ALLOW = 'Allow: GET, POST, DELETE';

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
            $this->modelAssociation->beginTransaction();
            if (!empty($this->options['customer_id_1']) &&
                !empty($this->options['customer_id_2'])
            ) {
                $this->options['customer_id_1'] = $this->options['customer_id_1'] ?? 0;
                $this->options['customer_id_2'] = $this->options['customer_id_2'] ?? 0;
                if ($this->options['customer_id_1'] > 0 &&
                    $this->options['customer_id_2'] > 0
                ) {
                    $this->modelAssociation->unsetAssociation(
                        $this->options['customer_id_1'],
                        $this->options['customer_id_2']
                    );
                } else {
                    throw new MyException('invalid ids', 400, false);
                }
            } elseif (!empty($this->options['customer_id'])) {
                $this->options['customer_id'] = $this->options['customer_id'] ?? 0;
                if ($this->options['customer_id'] > 0) {
                    $this->modelAssociation
                        ->unsetAllCustomersAssociations($this->options['customer_id']);
                } else {
                    throw new MyException('invalid ids', 400, false);
                }
            } else {
                $this->modelAssociation->unsetAllAssociations();
            }
            $this->modelAssociation->commit();
        } catch (\Exception $e) {
            $this->modelAssociation->rollBack();
            throw new \Exception(
                $e->getMessage(),
                method_exists($e, 'chooseCode') ? $e->chooseCode(500, 400) : 500
            );
        }

        $this->respond(204);
    }

    public function get(): void
    {
        if (empty($this->options['customer_id'])) {
            $this->respond(200, $this->modelAssociation->getAllAssociations());
        } else {
            if ($this->options['customer_id'] > 0) {
                $this->respond(
                    200,
                    $this
                        ->modelAssociation
                        ->getAllCustomersAssociations($this->options['customer_id'])
                );
            } else {
                throw new \Exception('invalid id', 400);
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
        $this->options['customer_id_1'] = $this->options['customer_id_1'] ?? 0;
        $this->options['customer_id_2'] = $this->options['customer_id_2'] ?? 0;

        if ($this->options['customer_id_1'] < 1 ||
            $this->options['customer_id_2'] < 1
        ) {
            throw new \Exception('invalid ids', 400);
        }

        try {
            $this->modelAssociation->beginTransaction();
            try {
                $this->modelAssociation->checkAssociation(
                    $this->options['customer_id_1'],
                    $this->options['customer_id_2']
                );
            } catch (\Exception $e) {
                throw new MyException('asscociation exists.', 400, false);
            }
            $this->modelAssociation->setAssociation(
                $this->options['customer_id_1'],
                $this->options['customer_id_2']
            );
            $this->modelAssociation->commit();
        } catch (\Exception $e) {
            $this->modelAssociation->rollBack();
            if (method_exists($e, 'chooseCode')) {
                throw new MyException(
                    $e->getMessage(),
                    $e->chooseCode(500, 400),
                    true
                );
            } else {
                throw new \Exception($e->getMessage(), 500);
            }
        }

        $this->respond(204);
    }

    public function put(): void
    {
        header(self::HEADER_ALLOW);
        parent::put();
    }

    public function trace(): void
    {
        header(self::HEADER_ALLOW);
        parent::trace();
    }
}
