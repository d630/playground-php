<?php

namespace corg;

class Model
{
    public function beginTransaction()
    {
        \corg\Db::getInstance()
            ->beginTransaction();
    }

    public function commit()
    {
        \corg\Db::getInstance()
            ->commit();
    }

    public function rollBack()
    {
        \corg\Db::getInstance()
            ->rollBack();
    }

    public function nullifyStr($str)
    {
        return empty(trim($str)) ? null : $str;
    }
}
