<?php

declare(strict_types=1);

namespace App\Model;

class Story extends AbstractModel
{
    protected static $tableName = 'story';

    // add user data to post
    protected static function createObject(array $data): AbstractModel
    {
        if ($userId = $data['user_id'] ?? null) {
            $user = User::getOne('id', $userId);
            $data['user_name'] = "{$user->getUserName}";
        }

        $data['stories'] = [];
        if ($storyId = $data['id'] ?? null) {
            $stories = Story::getMultiple('story_id', $storyId);
            $data['stories'] = $stories;
        }

        return parent::createObject($data);
    }
}