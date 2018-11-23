<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Auth\Request;

use D630\Corg\Model\Db\Db;
use D630\Corg\Request\StandardRequest as PStandardRequest;

class StandardRequest extends PStandardRequest implements StandardRequestInterface
{
    public function getEmployee(?string $nickname, ?string $entityType): array
    {
        $pod = Db::getInstance()
            ->prepare('CALL get_employee(:nickname)');
        $pod->execute(['nickname' => $this->nullifyStr($nickname)]);

        return [$pod->fetchObject($entityType)];
    }

    public function setEmployee(?string $nickname, ?string $password): void
    {
        Db::getInstance()
            ->prepare('CALL set_employee(:nickname, :password)')
            ->execute(
                [
                    'nickname' => $this->nullifyStr($nickname),
                    'password' => $this->nullifyStr($password),
                ]
            );
    }
}
