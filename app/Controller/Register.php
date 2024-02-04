<?php
namespace App\Controller;

use App\Model\User;
use Base\AbstractController;

class Register extends AbstractController
{
    public function index()
    {
        
        return $this->view->render(
            'register.phtml',
            [
                'title' => 'Главная',
                'user' => $this->getUser(),
            ]
        );
    }

  

    public function register()
    {
        $name = (string) $_POST['name'];
        $email = (string) $_POST['email'];
        $password = (string) $_POST['password'];
        $password2 = (string) $_POST['password_2'];

        if (!$name || !$password) {
            return 'Не заданы имя и пароль';
        }

        if (!$email) {
            return 'Не задан email';
        }

        if ($password !== $password2) {
            return 'Введенные пароли не совпадают';
        }

        if (mb_strlen($password) < 4) {
            return 'Пароль слишком короткий. Длина пароля должна быть больше 4х символов';
        }

        $userData = [
            'name' => $name,
            'registration_date' => date('Y-m-d H:i:s'),
            'password' => $password,
            'email' => $email,
        ];
        $user = new User($userData);
        $user->save();

        $this->session->authUser($user->getId());
        $this->redirect('/blog');
    }
}