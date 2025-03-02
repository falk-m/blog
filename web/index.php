<?php

use app\Blog;

require_once(__DIR__ . '/vendor/autoload.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$app = new Blog();

if (!trim($app->requestUri, '/')) {
    $action =  require_once(__DIR__ . '/pages/home.php');
} elseif (strpos($app->requestUri, '/media') === 0) {
    $action = require_once(__DIR__ . '/pages/media.php');
} elseif (strpos($app->requestUri, '/identicon') === 0) {
    $action = require_once(__DIR__ . '/pages/identicon.php');
} elseif (strpos($app->requestUri, '/update') === 0) {
    $action = require_once(__DIR__ . '/pages/update.php');
} elseif (strpos($app->requestUri, '/feed.xml') === 0) {
    $action = require_once(__DIR__ . '/pages/feed.php');
} else {
    $action = require_once(__DIR__ . '/pages/detail.php');
}


$action($app);
