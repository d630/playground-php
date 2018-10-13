<?php

namespace corg\Model;

class Auth extends \corg\Model
{
    public function getEmployee($nickname)
    {
        $pod = \corg\Db::getInstance()
            ->prepare('CALL get_employee(:nickname)');
        $pod->execute(['nickname' => $this->nullifyStr($nickname)]);

        return $pod->fetch();
    }

    public function isNickname($nickname)
    {
        $pod = \corg\Db::getInstance()
            ->prepare('CALL is_nickname(:nickname)');
        $pod->execute(['nickname' => $this->nullifyStr($nickname)]);

        return $pod->fetch(\PDO::FETCH_COLUMN);
    }

    public function setEmployee($nickname, $password)
    {
        \corg\Db::getInstance()
            ->prepare('CALL set_employee(:nickname, :password)')
            ->execute(
                [
                    'nickname' => $this->nullifyStr($nickname),
                    'password' => $this->nullifyStr($password)
                ]
            );
    }
}
