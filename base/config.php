<?php
const DB_USER = 'root';
const DB_NAME = 'ls5mvc';
const DB_HOST = 'localhost';
const DB_PASSWORD = '';

const ADMIN_IDS = [2];

function dd(...$args)
{
    echo '<pre>';
    var_dump($args);
    echo '</pre>';
    die;
}

function d(...$args)
{
    echo '<pre>';
    var_dump($args);
    echo '</pre>';    
}