<?php

namespace App\Model;

class User extends AbstractModel
{
    protected static $tableName = 'user';

    public function getPassword()
    {
        return $this->__get('password');
    }

    public function getRole()
    {
        return $this->__get('role');

    }
}