<?php
namespace App\Controller\Admin;

use App\Controller\Admin;
use App\Model\Eloquent\User;

class Users extends Admin
{
    public function index()
    {        

        //dd2(User::getList());        
        return $this->view->render(
            'admin/users.phtml',            
            [
                'allusers' => User::getList(),                                    
                'loggedin_user' => $this->getUser()                
            ]
        );
    }

    public function saveUser()
    {
        $id = (int) $_POST['id'];
        $name = (string) $_POST['name'];
        $email = (string) $_POST['email'];
        $password = (string) $_POST['password'];

        $user = User::getById($id);
        if (!$user) {
            return $this->response(['error' => 'нет пользователя']);
        }

        if (!$name) {
            return $this->response(['error' => 'не указано имя']);
        }

        if (!$email) {
            return $this->response(['error' => 'не указан email']);
        }

        if ($password && mb_strlen($password) < 4) {
            return $this->response(['error' => 'Пароль слишком короткий. Длина пароля должна быть больше 4х символов']);
        }

        $user->name = $name;
        $user->email = $email;

        /** @var User $emailUser */
        $emailUser = User::getByEmail($email);
        if ($emailUser && $emailUser->id != $id) {
            return $this->response(['error' => 'Этот email уже используется для uid#' . $emailUser->id]);
        }

        if ($password) {
            $user->password = User::getPasswordHash($password);
        }
        $user->save();

        return $this->response(['result' => 'ok']);

    }

    public function deleteUser()
    {
        $id = (int) $_POST['id'];

        $user = User::getById($id);
        if (!$user) {
            return $this->response(['error' => 'нет пользователя']);
        }

        $user->delete();

        return $this->response(['result' => 'ok']);
    }

    public function addUser()
    {
        $name = (string) $_POST['name'];
        $email = (string) $_POST['email'];
        $password = (string) $_POST['password'];

        if (!$name || !$password) {
            return 'Не заданы имя и пароль';
        }

        if (!$name) {
            return $this->response(['error' => 'не указано имя']);
        }

        if (!$email) {
            return $this->response(['error' => 'не указан email']);
        }

        if (!$password || mb_strlen($password) < 4) {
            return $this->response(['error' => 'Пароль слишком короткий. Длина пароля должна быть больше 4х символов']);
        }

        /** @var User $emailUser */
        $emailUser = User::getByEmail($email);
        if ($emailUser) {
            return $this->response(['error' => 'Этот email уже используется для uid#' . $emailUser->id]);
        }

        $userData = [
            'name' => $name,
            'created_at' => date('Y-m-d H:i:s'),
            'password' => User::getPasswordHash($password),
            'email' => $email,
        ];
        $user = new User($userData);
        $user->save();

        return $this->response(['result' => 'ok']);

    }

    public function response(array $data)
    {
        header('Content-type: application/json');
        return json_encode($data);
    }
}