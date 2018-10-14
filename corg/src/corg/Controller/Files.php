<?php

namespace corg\Controller;

class Files extends \corg\Controller
{
    private $model;
    private $config;

    public function __construct()
    {
        parent::__construct();
        $this->model = new \corg\Model\Files();
        $this->config = \corg\Config::get('file');
    }

    public function listAction($options)
    {
        $id = $options['id'] ?? null;

        $this->render('index/file/list.phtml',
            [
                'id' => $id,
                'files' => $this->model->getAllFilesTiny(),
                'error_msg' => $this->error_msg,
                'file' => $this->model->getFile($id)
            ]
        );
    }

    public function addAction($options)
    {
        $activities = (new \corg\Model\Activity())->getAllActivitiesTiny();

        $activity_id = null;
        if (!empty($options['activity_id'])) {
            $activity_id = $options['activity_id'];
        }

        if (!empty($_POST)) {
            switch ($_POST['action']) {
            case 'upload':
                switch ($_FILES['uploaded_file']['error']) {
                case 0:
                    try {
                        $_FILES['uploaded_file']['tmp_file'] = $this->config['upload_dir'] . '.' . basename($_FILES['uploaded_file']['tmp_name']);
                        move_uploaded_file(
                            $_FILES['uploaded_file']['tmp_name'],
                            $_FILES['uploaded_file']['tmp_file']
                        );
                        if (!is_readable($_FILES['uploaded_file']['tmp_file'])) {
                            throw new \Exception('could not move tmp file.', 500);
                        }
                    } catch (\Exception $e) {
                        $this->error_msg[] = 'could not handle tmp file. please try again.';
                    }
                    break;
                case 1:
                case 2:
                    $this->error_msg[] = 'max file size reached: ';
                    $this->error_msg[0] .= $_FILES['uploaded_file']['size'] . 'B >';
                    $this->error_msg[0] .= ini_get('upload_max_filesize');
                default:
                    $this->error_msg[] = 'could not upload file.';
                }
                goto render;
            case 'ok':
                try {
                    $this->model->beginTransaction();
                    $this->model->setFile(
                        $_POST['size'],
                        $_POST['mtype'],
                        $_POST['name'],
                        $_POST['description']
                    );
                    $this->model->commit();
                    rename(
                        $_POST['tmp_file'],
                        $this->config['upload_dir'] . $this->model->getLastFileId()
                    );
                } catch (\Exception $e) {
                    $this->model->rollBack();
                    unlink($_POST['tmp_file']);
                    throw new \Exception($e, 500);
                }
                try {
                    $this->model->beginTransaction();
                    $this->model->setReference(
                        $_POST['activity_id'],
                        $this->model->getLastFileId()
                    );
                    $this->model->commit();
                } catch (\Exception $e) {
                    $this->model->rollBack();
                    throw new \Exception($e, 500);
                }
            }
            header('Location: /files/list/' . $this->model->getLastFileId());
            exit;
        }

        render:
        $this->render('index/file/add.phtml',
            [
                'error_msg' => $this->error_msg,
                'activity_id' => $activity_id ?: $_POST['activity_id'] ?? null,
                'activities' => $activities,
                '_file' => $_FILES['uploaded_file'] ?? null,
            ]
        );
    }

    public function deleteAction($options)
    {
        if (empty($options['id'])) {
            $this->error_msg[] = 'need an id.';
            $this->listAction(null);
        } else {
            $location = $this->config['upload_dir'] . $options['id'];
            try {
                $this->model->beginTransaction();
                if (is_readable($location)) {
                    unlink($location);
                }
                $this->model->unsetFile($options['id']);
                $this->model->commit();
            } catch (\Exception $e) {
                $this->model->rollBack();
                throw new \Exception($e, 500);
            }
            header('Location: /files/list/' . $this->model->getLastFileId());
        }

        exit;
    }

    public function referenceAction($options)
    {
        if (empty($options['file_id'])) {
            $this->error_msg[] = 'need a file.';
            $options['file_id'] = null;
        }

        $activities = $this->model->getAbleToReference($options['file_id']);
        $file_name = $this->model->getFileName($options['file_id']);

        if (!empty($_POST)) {
            if ($_POST['action'] == 'ok') {
                try {
                    $this->model->beginTransaction();
                    $this->model->setReference(
                        $_POST['activity_id'],
                        $_POST['file_id']
                    );
                    $this->model->commit();
                } catch (\Exception $e) {
                    $this->model->rollBack();
                    throw new \Exception($e, 500);
                }
            }
            header('Location: /files/list/' . $_POST['file_id']);
            exit;
        }

        $this->render('index/file/reference.phtml',
            [
                'error_msg' => $this->error_msg,
                'activities' => $activities,
                'file_id' => $options['file_id'],
                'file_name' => $file_name
            ]
        );
    }

    public function dereferenceAction($options)
    {
        if (!empty($_POST)) {
            if ($_POST['action'] == 'ok') {
                if (empty($_POST['file_id'])) {
                    $this->error_msg[] = 'need an file name.';
                    goto render;
                }
                if (empty($_POST['ids'])) {
                    $this->error_msg[] = 'check in an activity.';
                    goto render;
                }
                try {
                    $this->model->beginTransaction();
                    foreach ($_POST['ids'] as $id) {
                        $this->model->unsetReference(
                            $id,
                            $_POST['file_id']
                        );
                    }
                    $this->model->commit();
                } catch (\Exception $e) {
                    $this->model->rollBack();
                    throw new \Exception($e, 500);
                }
                $orphans = $this->model->getOrphans();
                if (count($orphans)) {
                    try {
                        $this->model->unsetOrphans();
                    } catch (\Exception $e) {
                        $this->model->rollBack();
                        throw new \Exception($e, 500);
                    }
                    foreach ($orphans as $k) {
                        if (is_readable($config['upload_dir'] . $k)) {
                            unlink($config['upload_dir'] . $k);
                        }
                    }
                }
            }
            header('Location: /files/list/' . $_POST['file_id']);
            exit;
        }

        render:
        $this->render('index/file/dereference.phtml',
            [
                'error_msg' => $this->error_msg,
                'references' => $this->model->getReferences($options['file_id'] ?? null),
                'file_id' => $options['file_id'] ?? null,
                'file_name' => $this->model->getFileName($options['file_id'] ?? null)
            ]
        );
    }

    public function downloadAction($options)
    {
        if (empty($options['download_file_id'])) {
            $this->error_msg[] = 'need a file id.';
            goto error;
        }

        if (!is_numeric($options['download_file_id'])) {
            $this->error_msg[] = 'unknown file.';
            goto error;
        }

        if (!is_readable($this->config['upload_dir'] . $options['download_file_id'])) {
            $this->error_msg[] = 'unknown file.';
            goto error;
        }

        $file = $this->model->getFile($options['download_file_id']);
        $file = $file[0];
        if (empty($file['name'])) {
            $this->error_msg[] = 'unknown file.';
            goto error;
        }

        $file['upload_dir'] = $this->config['upload_dir'];

        // if (empty($file['mtype'])) {
            $file['mtype'] = mime_content_type($file['upload_dir'] . $file['id']);
        // }

        if (empty($file['size'])) {
            $file['size'] = filesize($file['upload_dir'] . $file['id']);
        }

        $this->render('index/file/download.phtml', $file);
        exit;

        error:
        $this->listAction(null);
    }
}
