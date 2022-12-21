<?php

session_start();

require_once "vendor/autoload.php";
require_once "src/Common/Environment.php";
require_once "vendor/slim/slim/Slim/Slim.php";

use Controller\AdminController;
use Controller\IndexController;
use Slim\Slim;
use Model\User;

$app = new Slim();
Environment::load(__DIR__);

$app->get('/', function () {
    $page = new IndexController();
    $page->setTpl('index');
});

$app->get('/admin', function () {
    $page = new AdminController();
    $page->setTpl('index');
    User::verifyLogin();
});

$app->get('/login', function () {
    $page = new AdminController([
        "header"=>false,
        "footer"=>false
    ]);
    $page->setTpl('login');
});

$app->post('/login', function () {
    User::login($_POST["login"], $_POST["password"]);
    header("Location: /admin");
    exit;
});

$app->get('/logout', function () {
    User::logout();
    header("Location: /login");
    exit;
});


$app->run();

