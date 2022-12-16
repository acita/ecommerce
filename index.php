<?php

require_once "src/Common/Includes.php";
require_once "vendor/slim/slim/Slim/Slim.php";

use Controller\AdminController;
use Controller\IndexController;
use \Slim\Slim;

$app = new Slim();

// $app->config('debug', true);

$app->get('/', function () {
    $page = new IndexController();
    $page->setTpl('index');
});

$app->get('/admin', function () {
    $page = new AdminController();
    $page->setTpl('index');
});

$app->run();

