<?php

declare(strict_types=1);

namespace D630\Corg\Entity;

use D630\Corg\Request\RequestInterface;

class File implements \JsonSerializable, EntityInterface
{
    private $description;
    private $employee_id;
    private $id;
    private $mtime;
    private $mtype;
    private $name;
    private $size;
    private $tmp_name;

    public static function get(int $id, RequestInterface $model): array
    {
        return $model->getFile($id, __CLASS__);
    }

    public function getDescription(): string
    {
        return (string) $this->description;
    }

    public function getEmployeeId(): int
    {
        return (int) $this->employee_id;
    }

    public function getId(): int
    {
        return (int) $this->id;
    }

    public function getMtime(): int
    {
        return (int) $this->mtime;
    }

    public function getMtype(): string
    {
        return (string) $this->mtype;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }

    public function getSize(): int
    {
        return (int) $this->size;
    }

    public function getTmpName(): string
    {
        return (string) $this->tmp_name;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'mtime' => $this->getMtime(),
            'size' => $this->getSize(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'employee_id' => $this->getEmployeeId(),
        ];
    }

    public function post(RequestInterface $model): void
    {
        try {
            $model->beginTransaction();
            $model->setFile(
                $this->getSize(),
                $this->getMtype(),
                $this->getName(),
                $this->getDescription(),
                $_SESSION['employee_id'] ?? $this->getEmployeeId()
            );
            $model->commit();
        } catch (\Exception $e) {
            $model->rollBack();
            throw new \Exception($e->getMessage(), 500);
        }
    }

    public function postMultiple(array $entityTypes, RequestInterface $model): void
    {
        try {
            $model->beginTransaction();
            foreach ($entityTypes as $v) {
                $model->setFile(
                    $v->getSize(),
                    $v->getMtype(),
                    $v->getName(),
                    $v->getDescription(),
                    $_SESSION['employee_id'] ?? $v->getEmployeeId()
                );
                break;
            }
            $model->commit();
        } catch (\Exception $e) {
            $model->rollBack();
            throw new \Exception($e->getMessage(), 500);
        }
    }
}
