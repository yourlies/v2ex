<?php
require './Kotori.php';

$app = new Kotori();

$config['APP_PATH'] = './app/';
$config['DB_HOST'] = '127.0.0.1';
$config['DB_USER'] = 'root';
$config['DB_PWD'] = 'root';
$config['DB_TYPE'] = 'mysql';
$config['DB_NAME'] = 'v2ex';
$config['URL_MODE'] = 'PATH_INFO';
$config['URL_ROUTE'] = array(
    't/([^/]+)' => 'Topic/viewTopic/$1',
    'signup' => array(
        'get' => 'User/signup',
        'post' => 'User/register',
    ),
    'signin' => array(
        'User/signin',
        'User/login',
    ),
    'balance' => 'User/balance',
    'new' => 'Topic/addTopic',
);
$config['ERROR_TPL'] = 'Public/404';

$app->run();
