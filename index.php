<?php

session_start();

require_once "vendor/autoload.php";
require_once "src/Common/Environment.php";
require_once "vendor/slim/slim/Slim/Slim.php";

use Slim\Slim;
use Controller\PageController;
use Model\User;
use Controller\AdminController;

$app = new Slim();
Environment::load(__DIR__);

$app->get('/', function () {
    $page = new PageController();
    $page->setTpl('index');
});

$app->get('/admin', function () {
    User::verifyLogin();
    $page = new AdminController();
    $page->setTpl('index');

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

$app->get('/admin/users/create', function () {
    User::verifyLogin();
    $page = new AdminController();
    $page->setTpl('users-create');
    exit;
});

$app->get('/admin/users/:iduser/delete', function ($iduser) {
    User::verifyLogin();

    $user = new User();
    $user->get((int)$iduser);
    $user->delete();
    header('Location: /admin/users');
    exit;
});

$app->get('/admin/users/:iduser', function ($iduser) {
    User::verifyLogin();
    $user = new User();
    $user->get((int)$iduser);
    
    $page = new AdminController();

    $page->setTpl('users-update', array(
        "user"=>$user->getValues()
    ));
    exit;
});

$app->get('/admin/users', function () {
    User::verifyLogin();
    $users = User::listAll();
    $page = new AdminController();
    $page->setTpl('users', array(
        "users"=>$users
    ));
    exit;
});

$app->post('/admin/users/create', function () {
    User::verifyLogin();
    $user = new User();

    $_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;

    $user->setData($_POST);
    $user->save();
    header('Location: /admin/users');
    exit;
});

$app->post('/admin/user/update/:iduser', function ($iduser) {
    User::verifyLogin();
    $user = new User();
    $user->get((int)$iduser);
    $user->setData($_POST);
    $user->update();
    header('Location: /admin/users');
    exit;
});

$app->get('/admin/forgot', function(){
    $page = new AdminController([
        "header"=>false,
        "footer"=>false
    ]);
    $page->setTpl('forgot');
});

$app->post('/admin/forgot', function(){
    $_POST["email"];
    $user = User::getForgot($_POST["email"]);
});

$app->run();
