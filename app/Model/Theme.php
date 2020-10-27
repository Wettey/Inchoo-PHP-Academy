<?php

declare(strict_types=1);

namespace App\Model;

class Theme extends AbstractModel
{
    protected static $tableName = 'theme';

    protected static function createObject(array $data): AbstractModel
    {
        if ($userId = $data['user_id'] ?? null) {
            $user = User::getOne('id', $userId);
            $data['user_name'] = "{$user->getUser_name()} {$user->getEmail()}";
        }

        return parent::createObject($data);
    }
}
