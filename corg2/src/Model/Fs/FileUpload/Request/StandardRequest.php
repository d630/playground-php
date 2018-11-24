<?php

declare(strict_types=1);

namespace D630\Corg\Model\Fs\FileUpload\Request;

use D630\Corg\Config;
use D630\Corg\MyException;
use D630\Corg\Request\StandardRequest as PStandardRequest;
use D630\Corg\Util;

class StandardRequest extends PStandardRequest implements StandardRequestInterface
{
    private $uploadDirInfo;

    public function __construct()
    {
        $configFile = Config::get('file');
        $this->uploadDirInfo = new \SplFileInfo($configFile['upload_dir']);

        if (!$this->uploadDirInfo->isDir() ||
            !$this->uploadDirInfo->isWritable()) {
            throw new \Exception('configured upload_dir is not a writable dir', 500);
        }
    }

    public function beginTransaction(): void
    {
    }

    public function checkTmpName(?string $tmpName = null): string
    {
        $tmpNameInfo = new \SplFileInfo(
            filter_var($tmpName, \FILTER_SANITIZE_STRING)
        );

        $tmpFullNameInfo = new \SplFileInfo(
            Util::buildFilePath($this->getUploadDir(), $tmpNameInfo->getFilename())
        );

        if ($tmpNameInfo->getPathname() === '' ||
            is_numeric($tmpNameInfo->getFilename()) ||
            $tmpNameInfo->isDir() ||
            !$tmpFullNameInfo->isFile() ||
            !$tmpFullNameInfo->isWritable()
        ) {
            throw new \Exception(
                'could not handle tmp_file: ' . $tmpFullNameInfo->__toString(),
                422
            );
        }

        return $tmpFullNameInfo->getPathname();
    }

    public function commit(): void
    {
    }

    public function emptyUploadDir(): void
    {
        $it = new \FilesystemIterator(
            $this->getUploadDir(),
            \FilesystemIterator::KEY_AS_PATHNAME |
            \FilesystemIterator::CURRENT_AS_FILEINFO |
            \FilesystemIterator::SKIP_DOTS |
            \FilesystemIterator::UNIX_PATHS
        );

        foreach ($it as $f) {
            if ($f->isFile() && $f->isWritable()) {
                unlink($f->getPathname());
            }
        }

        // array_map(
        //     function ($file) {
        //         unlink($file);
        //     },
        //     array_filter(
        //     )
        // );
    }

    public function errorInfo(): void
    {
    }

    public function getUploadDir(): string
    {
        return $this->uploadDirInfo->getRealPath();
    }

    public function processUpload(): int
    {
        if (empty(@$_FILES['uploaded_file'])) {
            throw new \Exception('there is no valid uploaded_file variable', 422);
        }

        switch ($_FILES['uploaded_file']['error']) {
            case \UPLOAD_ERR_OK:
                break;
            case \UPLOAD_ERR_INI_SIZE:
            case \UPLOAD_ERR_FORM_SIZE:
                throw new MyException(
                    sprintf(
                        "max file size reached: %dB > %s\n",
                        $_FILES['uploaded_file']['size'],
                        ini_get('upload_max_filesize')
                    ),
                    422,
                    true
                );
            case \UPLOAD_ERR_NO_FILE:
                throw new MyException('no file has been uploaded', 422, true);
            default:
                throw new MyException('could not upload file', 500, true);
        }

        $tmp_file = Util::buildFilePath(
            $this->getUploadDir(),
            str_replace(
                'php',
                'corg1970',
                basename($_FILES['uploaded_file']['tmp_name'])
            )
        );

        if (!move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $tmp_file)) {
            throw new \Exception('could not move uploaded file', 500);
        }

        $_FILES['uploaded_file']['tmp_name'] = basename($tmp_file);
        $_FILES['uploaded_file']['type'] = mime_content_type($tmp_file);
        $_FILES['uploaded_file']['size'] = filesize($tmp_file);

        return 201;
    }

    public function rename(string $s1, int $s2): void
    {
        rename($s1, Util::buildFilePath($this->getUploadDir(), $s2));
    }

    public function rollBack(): void
    {
    }

    public function unlink(int $f): void
    {
        $fileInfo = new \SplFileInfo(Util::buildFilePath($this->getUploadDir(), $f));

        if ($fileInfo->isFile() && $fileInfo->isWritable()) {
            unlink($f);
        }
    }

    public function unlinkArray(array $arr = []): void
    {
        foreach ($arr as $f) {
            $this->unlink($f);
        }
    }
}
