<?php

declare(strict_types=1);

namespace D630\Corg\Entity;

use D630\Corg\Request\RequestInterface;

class Auth implements \JsonSerializable, EntityInterface
{
    private $id;
    private $last_activity_id;
    private $last_customer_id;
    private $last_file_id;
    private $nickname;
    private $password;
    private $password2;

    public static function get(string $nickname, RequestInterface $model): array
    {
        return $model->getEmployee($nickname, __CLASS__);
    }

    public function getId(): int
    {
        return (int) $this->id;
    }

    public function getLastActivityId(): int
    {
        return (int) $this->last_activity_id;
    }

    public function getLastCustomerId(): int
    {
        return (int) $this->last_customer_id;
    }

    public function getLastFileId(): int
    {
        return (int) $this->last_file_id;
    }

    public function getNickname(): string
    {
        return (string) $this->nickname;
    }

    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function getPassword2(): string
    {
        return (string) $this->password2;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'nickname' => $this->getNickname(),
            'password' => $this->getPassword(),
            'last_activity_id' => $this->getLastActivityId(),
            'last_customer_id' => $this->getLastCustomerId(),
            'last_file_id' => $this->getLastFileId(),
        ];
    }

    public function post(RequestInterface $model): void
    {
        try {
            $model->beginTransaction();
            $model->setEmployee(
                $this->getNickname(),
                $this->getPassword()
            );
            $model->commit();
        } catch (\Exception $e) {
            $model->rollBack();
            throw new \Exception($e->getMessage(), 500);
        }
    }

    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
