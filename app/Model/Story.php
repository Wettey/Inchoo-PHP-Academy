<?php

declare(strict_types=1);

namespace App\Model;

class Story extends AbstractModel
{
    protected static $tableName = 'story';

    // add the creators user data
    protected static function createObject(array $data): AbstractModel
    {
        $data['stories'] = [];
        if ($storyId = $data['id'] ?? null) {
            $stories = Story::getMultiple('', $storyId);
            $data['stories'] = $stories;
        }

        if ($userId = $data['user_id'] ?? null) {
            $user = User::getOne('user_id', $userId);
            $data['user_name'] = "{$user->getUserName}";
        }

        $data['themes'] = [];
        if ($themeId = $data['id'] ?? null) {
            $themes = Theme::getMultiple('theme_id', $themeId);
            $data['themes'] = $themes;
        }



        return parent::createObject($data);
    }
}