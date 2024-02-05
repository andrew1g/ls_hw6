<?php
require_once '../vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader('twig/');
$twig = new \Twig\Environment($loader);

echo $twig->render('test.twig', ['text' => 'TWIG TEST']);