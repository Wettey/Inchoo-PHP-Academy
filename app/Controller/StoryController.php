<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Story;

class StoryController extends AbstractController
{
    private $story;

    public function __construct()
    {
        $this->story = new Story();
        parent::__construct();
    }

    public function indexAction(): string
    {
        return $this->view->render('story', [
            'stories' => Story::getAll()
        ]);
    }
}