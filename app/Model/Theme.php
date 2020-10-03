<?php

declare(strict_types=1);

namespace App\Model;

class Theme extends AbstractModel
{
    protected static $tableName = 'theme';

    //add the user who created the theme
    protected static function createObject(array $data): AbstractModel
    {
        if ($userId = $data['user_id'] ?? null) {
            $user = User::getOne('id', $userId);
            $data['user_name'] = "{$user->getUserName()}";
        }

        $data['themes'] = [];
        if ($postId = $data['id'] ?? null) {
            $comments = Theme::getMultiple('theme_id', $postId);
            $data['themes'] = $comments;
        }

        return parent::createObject($data);
    }
}
