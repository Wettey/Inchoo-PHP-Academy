<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Theme;

class ThemeController extends AbstractController
{
    private $theme;

    public function __construct()
    {
        $this->theme = new Theme();
        parent::__construct();
    }

    // home page render, show all themes from the database
    public function readAction(): string
    {
        return $this->view->render('home', [
            'themes' => Theme::getAll('name ASC')
        ]);
    }

    // new theme creation view
    public function newAction(): string
    {
        if ($this->authorization->isLoggedIn()) {
        return $this->view->render('themes' . DIRECTORY_SEPARATOR . 'themeNew');
        }
    }

    // create a new theme
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
            echo 'Missing theme name or theme category or both';
            header('Location: /themes/themeNew');
            return;
        }

        // file upload (image)
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
                if ($fileSize < 1000000) {
                    $fileNameNew = uniqid('', false) . '.' . $fileActualExt;
                    $fileDestination = 'img/' . $fileNameNew;
                    if ($fileType === 'png'||'jpg'||'jpeg') {
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
                            echo 'Error: There was an error uploading your image!';
                        }
                    } else {
                        echo 'Error: Only jpg, jpeg and png files types allowed.';
                    }
                } else {
                    echo 'Error: Image has to be less than 1mb!';
                }
            } else {
                echo 'Error: Please check your data and try again!';
            }
        }
    }

    // update a theme view
    public function editAction(): string
    {
        if ($this->authorization->isLoggedIn()) {
            return $this->view->render('themes' . DIRECTORY_SEPARATOR . 'themeUpdate');
        }
    }
    // theme update
    public function updateAction()
    {
        if (!$this->isPost() || !$this->authorization->isLoggedIn()) {
            header('Location: /');
            return;
        }
    }

    // delete a theme
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
