<?php
namespace App\Controller;

use App\Model\Message;
use Base\AbstractController;

class Blog extends AbstractController
{
    public function index()
    {
        if (!$this->getUser()) {
            $this->redirect('/login');
        }
        $messages = Message::getList();
        if ($messages) {
            $userIds = array_map(function (Message $message) {
                return $message->getAuthorId();
            }, $messages);
            $users = \App\Model\User::getByIds($userIds);
            array_walk($messages, function (Message $message) use ($users) {
                if (isset($users[$message->getAuthorId()])) {
                    $message->setAuthorid($users[$message->getAuthorId()]);
                }
            });
        }
        return $this->view->render('blog.phtml', [
            'messages' => $messages,
            'user' => $this->getUser()
        ]);
    }

    public function addMessage()
    {


        //dd($_FILES['image']['tmp_name']);    
        if (!$this->getUser()) {
            $this->redirect('/login');
        }

        $text = (string) $_POST['text'];
        if (!$text) {
            echo 'Сообщение не может быть пустым';
        }

        $message = new Message([
            'text' => $text,
            'author_id' => $this->getUserId(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

      

        $message = new Message([
            'text' => $text,
            'author_id' => $this->getUserId(),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        

        if (isset($_FILES['image']['tmp_name']) && ($_FILES['image']['tmp_name'])!=='') {    
                             
            $message->loadFile($_FILES['image']['tmp_name']);
        }

      

        $message->save();
        $this->redirect('/blog');

    }

    public function Show20Messages()
    {
        if (!$this->getUser()) {
            $this->redirect('/login');
        }
        $messages = Message::getList();
        if ($messages) {
            $userIds = array_map(function (Message $message) {
                return $message->getAuthorId();
            }, $messages);
            $users = \App\Model\User::getByIds($userIds);
            array_walk($messages, function (Message $message) use ($users) {
                if (isset($users[$message->getAuthorId()])) {
                    $message->setAuthorid($users[$message->getAuthorId()]);
                }
            });
        }
        return $this->view->render('blog.phtml', [
            'messages' => $messages,
            'user' => $this->getUser()
        ]);
    }

   

    private function error($txterror)
    {
       
        //$this->redirect('/blog');
        //Echo $txterror;
    }

    public function twig()
    {
        return $this->view->renderTwig('test.twig',['text'=>'FIRST TWIG RENDER']);
        
    }


    public function twig2()
    {
        return $this->view->renderTwig2();        
    }
    

}