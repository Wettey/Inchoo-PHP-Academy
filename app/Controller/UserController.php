<?php

namespace App\Controller;

use App\Model\User;

class UserController extends AbstractController
{
    // login view
    public function loginAction()
    {
        if (!$this->authorization->isLoggedIn()) {
            return $this->view->render('login');
        }

        header('Location: /');
    }

    // register view
    public function registerAction()
    {
        if (!$this->authorization->isLoggedIn()) {
            return $this->view->render('register');
        }

        header('Location: /');
    }

    //register validation
    public function registerSubmitAction()
    {
        if (!$this->isPost()) {
            // only POST requests are allowed
            header('Location: /');
            return;
        }

        $requiredKeys = ['user_name', 'email', 'password', 'confirm_password'];
        if (!$this->validateData($_POST, $requiredKeys)) {
            // set error message
            header('Location: /user/register');
            return;
        }

        if ($_POST['password'] !== $_POST['confirm_password']) {
            // set error message
            header('Location: /user/register');
            return;
        }

        $user = User::getOne('user_name', $_POST['user_name']);

        if ($user->getId()) {
            // user already exists
            header('Location: /user/register');
            return;
        }

        $user = User::getOne('email', $_POST['email']);

        if ($user->getId()) {
            // email already exists
            header('Location: /user/register');
            return;
        }

        User::insert([
            'user_name' => $_POST['user_name'] ?? null,
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ]);

        header('Location: /user/login');
    }

    // login validation
    public function loginSubmitAction()
    {

        if (!$this->isPost() || $this->authorization->isLoggedIn()) {
            // only POST requests are allowed
            header('Location: /');
            return;
        }

        $requiredKeys = ['email', 'password'];
        if (!$this->validateData($_POST, $requiredKeys)) {
            // you didn't enter your email or password correctly
            header('Location: /user/login');
            return;
        }

        $user = User::getOne('email', $_POST['email']);

        if (!$user->getId() || !password_verify($_POST['password'], $user->getPassword())) {
            // wrong username or password
            header('Location: /user/login');
            return;
        }

        $this->authorization->login($user);
        header('Location: /');
    }

    protected function validateData(array $data, array $keys): bool
    {
        foreach ($keys as $key) {
            $isValueValid = isset($data[$key]) && $data[$key];
            if (!$isValueValid) {
                return false;
            }
        }
        return true;
    }

    // user logout
    public function logoutAction()
    {
        if ($this->authorization->isLoggedIn()) {
            $this->authorization->logout();
        }

        header('Location: /');
    }

    // delete user account
    public function deleteAction()
    {
        if ($this->authorization->isLoggedIn()) {
            $this->authorization->delete();
        }

        header('Location: /');
    }
}
