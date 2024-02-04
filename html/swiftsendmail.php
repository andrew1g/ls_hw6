<?php
//require_once '../vendor/autoload.php';
require '../vendor/autoload.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.mail.ru', '465', 'ssl'))
  ->setUsername('swiftemail2024@mail.ru')
  ->setPassword('') //Пароль не указан в целях безопасности, так как код выложен на github
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('My mail message from Swift_Mailer'))
  ->setFrom(['swiftemail2024@mail.ru' => 'swiftemail2024'])
  ->setTo(['andmail123@mail.ru' => 'Andrew'])
  ->setBody('My mail message from Swift_Mailer')
  ;


// Send the message
$result = $mailer->send($message);

echo '<pre>';
var_dump($result);
echo '</pre>';