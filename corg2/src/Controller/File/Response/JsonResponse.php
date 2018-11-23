<?php

declare(strict_types=1);

namespace D630\Corg\Controller\File\Response;

use D630\Corg\Entity\File;
use D630\Corg\MyException;
use D630\Corg\Response\JsonResponse as PJsonResponse;
use D630\Corg\Util;
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
            $this->modelFile->beginTransaction();
            if (!empty($this->options['activity_id'])) {
                $this->options['activity_id'] = $this->options['activity_id'] ?? 0;
                if ($this->options['activity_id'] > 0) {
                    $keys = $this
                        ->modelFile
                        ->getAllActivitiesFileIds($this->options['activity_id']);
                    $this
                        ->modelFile
                        ->unsetAllActivitiesFiles($this->options['activity_id']);
                    $this
                        ->modelFileUpload
                        ->unlinkArray($keys);
                } else {
                    throw new MyException('invalid id', 400, false);
                }
            } elseif (!empty($this->options['customer_id'])) {
                $this->options['customer_id'] = $this->options['customer_id'] ?? 0;
                if ($this->options['customer_id'] > 0) {
                    $keys = $this
                        ->modelFile
                        ->getAllCustomersFileIds($this->options['customer_id']);
                    $this
                        ->modelFile
                        ->unsetAllCustomersFiles($this->options['customer_id']);
                    $this
                        ->modelFileUpload
                        ->unlinkArray($keys);
                } else {
                    throw new MyException('invalid id', 400, false);
                }
            } else {
                $this->options['file_id'] = $this->options['file_id'] ?? 0;
                if ($this->options['file_id'] > 0) {
                    $this
                        ->modelFile
                        ->unsetFile($this->options['file_id']);
                    $this
                        ->modelFileUpload
                        ->unlink($this->options['file_id']);
                } else {
                    $this
                        ->modelFile
                        ->unsetAllFiles();
                    $this
                        ->modelFileUpload
                        ->emptyUploadDir();
                }
            }
            $this->modelFile->commit();
        } catch (\Exception $e) {
            $this->modelFile->rollBack();
            throw new \Exception(
                $e->getMessage(),
                method_exists($e, 'chooseCode') ? $e->chooseCode(500, 400) : 500
            );
        }

        $this->respond(204);
    }

    public function get(): void
    {
        if (!empty($this->options['activity_id'])) {
            $this->options['activity_id'] = $this->options['activity_id'] ?? 0;
            if ($this->options['activity_id'] > 0) {
                $this->respond(
                    200,
                    $this
                        ->modelFile
                        ->getAllActivitiesFiles($this->options['activity_id'])
                );
            } else {
                throw new \Exception('invalid id', 400);
            }
        } elseif (!empty($this->options['customer_id'])) {
            $this->options['customer_id'] = $this->options['customer_id'] ?? 0;
            if ($this->options['customer_id'] > 0) {
                $this->respond(
                    200,
                    $this
                        ->modelFile
                        ->getAllCustomersFiles($this->options['customer_id'])
                );
            } else {
                throw new \Exception('invalid id', 400);
            }
        } elseif (filter_input(\INPUT_GET, 'alt', \FILTER_SANITIZE_STRING) === 'media') {
            $this->options['file_id'] = $this->options['file_id'] ?? 0;
            if ($this->options['file_id'] > 0) {
                $this->respondWithFileTransfer(
                    200,
                    Util::buildFilePath($this->modelFileUpload->getUploadDir(), $this->options['file_id']),
                    File::get($this->options['file_id'], $this->modelFile)
                );
            } else {
                throw new \Exception('invalid id', 400);
            }
        } else {
            $this->options['file_id'] = $this->options['file_id'] ?? 0;
            if ($this->options['file_id'] > 0) {
                $this->respond(
                    200,
                    File::get($this->options['file_id'], $this->modelFile)
                );
            } else {
                $this->respond(
                    200,
                    $this->modelFile->getAllFiles()
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
        if (!empty($_FILES)) {
            $this->respond($this->modelFileUpload->processUpload(), $_FILES);
            exit;
        }

        $file = $this->readInFromBody(
            new JsonDecoder(true),
            File::class
        );

        $tmp_name = $this->modelFileUpload->checkTmpName($file->getTmpName());

        // $oldFileId = $this->modelFile->getLastFileId();
        $file->post($this->modelFile);
        $newFileId = $this->modelFile->getLastFileId();

        // if (is_numeric($newFileId) && $newFileId !== $oldFileId) {
        $this->modelFileUpload->rename($tmp_name, $newFileId);
        $this->respond(201, File::get($newFileId, $this->modelFile));
        // } else {
        //     $this->respond(204);
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
