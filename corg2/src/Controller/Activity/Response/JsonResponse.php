<?php

declare(strict_types=1);

namespace D630\Corg\Controller\Activity\Response;

use D630\Corg\Entity\Activity;
use D630\Corg\MyException;
use D630\Corg\Response\JsonResponse as PJsonResponse;
use Karriere\JsonDecoder\JsonDecoder;

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
            $this->modelActivity->beginTransaction();
            if (!empty($this->options['customer_id'])) {
                $this->options['customer_id'] = $this->options['customer_id'] ?? 0;
                if ($this->options['customer_id'] > 0) {
                    $this->modelActivity->unsetAllCustomersActivities($this->options['customer_id']);
                } else {
                    throw new MyException('invalid id', 400, false);
                }
            } elseif (!empty($this->options['file_id'])) {
                $this->options['file_id'] = $this->options['file_id'] ?? 0;
                if ($this->options['file_id'] > 0) {
                    $this->modelActivity->unsetAllFilesActivities($this->options['file_id']);
                } else {
                    throw new MyException('invalid id', 400, false);
                }
            } else {
                $this->options['activity_id'] = $this->options['activity_id'] ?? 0;
                if ($this->options['activity_id'] > 0) {
                    $this->modelActivity->unsetActivity($this->options['activity_id']);
                } else {
                    $this->modelActivity->unsetAllActivities();
                }
            }
            $this->modelActivity->commit();
        } catch (\Exception $e) {
            $this->modelActivity->rollBack();
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
        //     $this->modelActivity->rollBack();
        //     throw new \Exception($e->getMessage(), 500);
        // }

        // foreach ($o as $k) {
        //     if (is_numeric($k) && is_writable($this->configFile['upload_dir'] . $k)) {
        //         unlink($this->configFile['upload_dir'] . $k);
        //     }
        // }

        $this->respond(204);
    }

    public function get(): void
    {
        if (!empty($this->options['customer_id'])) {
            $this->options['customer_id'] = $this->options['customer_id'] ?? 0;
            if ($this->options['customer_id'] > 0) {
                $this->respond(
                    200,
                    $this->modelActivity
                        ->getAllCustomersActivities($this->options['customer_id'])
                );
            } else {
                throw new \Exception('invalid id', 400);
            }
        } elseif (!empty($this->options['file_id'])) {
            $this->options['file_id'] = $this->options['file_id'] ?? 0;
            if ($this->options['file_id'] > 0) {
                $this->respond(
                    200,
                    $this->modelActivity
                        ->getAllFilesActivities($this->options['file_id'])
                );
            } else {
                throw new \Exception('invalid id', 400);
            }
        } else {
            $this->options['activity_id'] = $this->options['activity_id'] ?? 0;
            if ($this->options['activity_id'] > 0) {
                $this->respond(
                    200,
                    Activity::get($this->options['activity_id'], $this->modelActivity)
                );
            } else {
                $this->respond(
                    200,
                    $this->modelActivity->getAllActivities()
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
        $activities = $this->readMultipleInFromBody(
            new JsonDecoder(true),
            Activity::class
        );

        // $oldActivityId = $this->modelActivity->getLastActivityId();
        $activities[0]->postMultiple($activities, $this->modelActivity);
        $newActivityId = $this->modelActivity->getLastActivityId();

        // if ($newActivityId === $oldActivityId) {
        //     $this->respond(500);
        // } else {
        $this->respond(201, Activity::get($newActivityId, $this->modelActivity));
        // }
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
