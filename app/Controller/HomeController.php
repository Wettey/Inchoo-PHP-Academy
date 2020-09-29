<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Theme;

class HomeController extends AbstractController
{
    private $theme;

    public function __construct()
    {
        $this->theme = new Theme();
        parent::__construct();
    }

    public function indexAction(): string
    {
        return $this->view->render('home', [
            'themes' => Theme::getAll(),
        ]);
    }
}
