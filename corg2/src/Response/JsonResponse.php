<?php

declare(strict_types=1);

namespace D630\Corg\Response;

use D630\Corg\Config;
use D630\Corg\Entity\EntityInterface;
use Karriere\JsonDecoder\JsonDecoder;
use Karriere\JsonDecoder\Transformer;

class JsonResponse extends Response
{
    public function __construct(
        string $ns,
        array $models,
        array $settings,
        array $options
    ) {
        parent::__construct($ns, $models, $settings, $options);
    }

    protected function readInFromBody(
        JsonDecoder $jsonDecoder,
        string $entity,
        ?Transformer $transformer = null
    ): EntityInterface {
        if ($transformer !== null) {
            $jsonDecoder->register($transformer);
        }

        return $jsonDecoder->decode(file_get_contents('php://input'), $entity);
    }

    protected function readMultipleInFromBody(
        JsonDecoder $jsonDecoder,
        string $entity,
        ?Transformer $transformer = null
    ): array {
        if ($transformer !== null) {
            $jsonDecoder->register($transformer);
        }

        return $jsonDecoder->decodeMultiple(file_get_contents('php://input'), $entity);
    }

    protected function respond(int $code, array $body = []): void
    {
        // if (!\count($body) || !$body[0]) {
        //     throw new \Exception('empty result set', 404);
        // }

        $func = $this->configResponse['status'][$code] ?? @$this->configResponse['status'][200];
        $func();

        header('Expires: ' . Config::UNIX_TIME);
        header('Content-Type: application/json; charset=UTF-8');

        echo json_encode($body,
            \JSON_PRESERVE_ZERO_FRACTION |
            \JSON_UNESCAPED_UNICODE |
            \JSON_UNESCAPED_SLASHES
        );
    }

    protected function respondWithFileTransfer(
        int $code,
        string $uploadedFile,
        array $file
    ): void {
        $fileInfo = new \SplFileInfo($uploadedFile);
        $file = $file[0];

        if ($uploadedFile === '' ||
            !$fileInfo->isFile() ||
            !$fileInfo->isReadable() ||
            $file->getMtype() === '' ||
            $file->getName() === '' ||
            !is_numeric($file->getSize())
        ) {
            throw new \Exception('file is damaged', 500);
        }

        $func = $this->configResponse['status'][$code] ?? @$this->configResponse['status'][200];
        $func();

        set_time_limit(0);
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $file->getMtype());
        header('Content-Disposition: attachment; filename="' . $file->getName() . '"');
        header('Expires: ' . Config::UNIX_TIME);
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . $file->getSize());

        readfile($uploadedFile);
    }
}
