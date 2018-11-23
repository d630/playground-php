<?php

declare(strict_types=1);

namespace D630\Corg\Entity;

use D630\Corg\Request\RequestInterface;

class Activity implements \JsonSerializable, EntityInterface
{
    private $customer_id;
    private $description;
    private $employee_id;
    private $id;
    private $mtime;
    private $name;

    public static function get(int $id, RequestInterface $model)
    {
        return $model->getActivity($id, __CLASS__);
    }

    public function getCustomerId(): int
    {
        return (int) $this->customer_id;
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

    public function getMtime(): string
    {
        return (string) $this->mtime;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }

    public function jsonSerialize(): array
    {
        return [
            'customer_id' => $this->getCustomerId(),
            'description' => $this->getDescription(),
            'employee_id' => $this->getEmployeeId(),
            'id' => $this->getId(),
            'mtime' => $this->getMtime(),
            'name' => $this->getName(),
        ];
    }

    public function postMultiple(array $entityTypes, RequestInterface $model): void
    {
        try {
            $model->beginTransaction();
            foreach ($entityTypes as $v) {
                $model->setActivity(
                    $v->getName(),
                    $v->getDescription(),
                    $v->getCustomerId(),
                    $v->getEmployeeId()
                );
            }
            $model->commit();
        } catch (\Exception $e) {
            $model->rollBack();
            throw new \Exception($e->getMessage(), 500);
        }
    }
}
