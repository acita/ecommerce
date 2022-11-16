<?php

require_once "src/Common/Includes.php";
require_once "vendor/slim/slim/Slim/Slim.php";

use \Slim\Slim;
use \Controller\Page;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function () {
    $page = new Page();
    $page->setTpl('index');
});

$app->run();
