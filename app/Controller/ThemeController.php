<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Theme;
use App\Model\User;

class ThemeController extends AbstractController
{
    private $theme;

    public function __construct()
    {
        $this->theme = new Theme();
        parent::__construct();
    }

    public function indexAction(): string
    {
        return $this->view->render('theme', [
            'themes' => Theme::getAll('name DESC')
        ]);
    }

    public function newAction(): string
    {
        if ($this->authorization->isLoggedIn()) {
        return $this->view->render('themeNew');
        }
    }


    public function createAction()
    {
        if (!$this->isPost() || !$this->authorization->isLoggedIn()) {
            header('Location: /');
            return;
        }

        $themeName = $_POST['new_theme_name'];
        $themeCategory = $_POST['new_theme_category'];
        $themeDescription = $_POST['new_theme_description'];

        if (!$themeName || !$themeCategory) {
            echo 'Missing one or more requirements';
            header('Location: /theme/render');
            return;
        }

//IMAGE PART START
        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];
        $fileError = $_FILES['file']['error'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                    if ($fileSize < 100000) {
                        $fileNameNew = uniqid('', false) . '.' . $fileActualExt;
                        $fileDestination = 'img/' . $fileNameNew;
                        if (move_uploaded_file($fileTmpName, $fileDestination)) {
                            Theme::insert([
                                'name' => $themeName,
                                'category' => $themeCategory,
                                'description' => $themeDescription,
                                'image_path' => $fileDestination,
                                'user_id' => $this->authorization->getCurrentUser()->getId()
                            ]);
                            header('Location: /');
                        } else {
                            echo 'There was an error uploading your image!';
                        }
                    } else {
                        echo 'Image has to be less than 100kb!';
                        }
            } else {
                echo 'An error occurred, please check your data and try again!';
                }
        }
    }

    public function editAction(): string
    {
        if ($this->authorization->isLoggedIn()) {
            return $this->view->render('themeUpdate');
        }
    }

    public function updateAction()
    {
        if (!$this->isPost() || !$this->authorization->isLoggedIn()) {
            header('Location: /');
            return;
        }
    }

    public function deleteAction()
    {
        $themeId = $_GET['id'] ?? null;
        if (!$themeId || !$this->authorization->isLoggedIn()) {
            header('Location: /');
            return;
        }

        $theme = Theme::getOne('id', $themeId);

        if ($theme->getUserId() == $this->authorization->getCurrentUser()->getId()) {
            Theme::delete('id', $themeId);
        }

        header('Location: /');
    }
}
