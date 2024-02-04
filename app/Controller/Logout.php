<?php
namespace App\Controller;

use App\Model\User;
use Base\AbstractController;

class Logout extends AbstractController
{
    public function index()
    {
       
            session_destroy();               
            return $this->view->render(
            'login.phtml',
            [
                'title' => 'Главная',
                'user' => NULL
            ]
        );
    }

   
}