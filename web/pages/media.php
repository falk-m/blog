<?php

use app\Blog;
use app\FilesCollection;

return function (Blog $app) {
    $path = substr($app->requestUri, strlen('/media'));
    $path = str_replace([".."], "", $path);
    $path = $app->config['posts_dir'] . $path;

    $filesCollection = new FilesCollection();
    if (!$filesCollection->streamFile($path)) {
        $action = require(__DIR__ . '/404.php');
        $action($app);
    }
};
