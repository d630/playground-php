<?php

declare(strict_types=1);

namespace D630\Corg\Controller\Reference\Response;

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
            $this->modelReference->beginTransaction();
            if (!empty($this->options['activity_id']) &&
                !empty($this->options['file_id'])
            ) {
                $this->options['activity_id'] = $this->options['activity_id'] ?? 0;
                $this->options['file_id'] = $this->options['file_id'] ?? 0;
                if ($this->options['activity_id'] > 0 &&
                    $this->options['file_id'] > 0
                ) {
                    $this->modelReference->unsetReference(
                        $this->options['activity_id'],
                        $this->options['file_id']
                    );
                } else {
                    throw new MyException('invalid ids', 400, false);
                }
            } elseif (!empty($this->options['activity_id'])) {
                $this->options['activity_id'] = $this->options['activity_id'] ?? 0;
                if ($this->options['activity_id'] > 0) {
                    $this->modelReference->unsetAllActivitiesReferences($this->options['activity_id']);
                } else {
                    throw new MyException('invalid id', 400, false);
                }
            } elseif (!empty($this->options['file_id'])) {
                $this->options['file_id'] = $this->options['file_id'] ?? 0;
                if ($this->options['file_id'] > 0) {
                    $this->modelReference->unsetAllFilesReferences($this->options['file_id']);
                } else {
                    throw new MyException('invalid id', 400, false);
                }
            } else {
                $this->modelReference->unsetAllReferences();
            }
            $this->modelReference->commit();
        } catch (\Exception $e) {
            $this->modelReference->rollBack();
            throw new \Exception(
                $e->getMessage(),
                method_exists($e, 'chooseCode') ? $e->chooseCode(500, 400) : 500
            );
        }

        $this->respond(204);
    }

    public function get(): void
    {
        if (!empty($this->options['activity_id']) ||
            !empty($this->options['file_id'])
        ) {
            throw new MyException('no ids allowed', 400, false);
        }

        $this->respond(
            200,
            $this->modelReference->getAllReferences()
        );
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
        $this->options['activity_id'] = $this->options['activity_id'] ?? 0;
        $this->options['file_id'] = $this->options['file_id'] ?? 0;

        if ($this->options['activity_id'] < 1 ||
            $this->options['file_id'] < 1
        ) {
            throw new \Exception('invalid ids', 400);
        }

        try {
            $this->modelReference->beginTransaction();
            $this->modelReference->setReference(
                $this->options['activity_id'],
                $this->options['file_id']
            );
            $this->modelReference->commit();
        } catch (\Exception $e) {
            $this->modelReference->rollBack();
            throw new \Exception($e->getMessage(), 500);
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
