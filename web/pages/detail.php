<?php

use app\Blog;

return function (Blog $app) {

    $post = $app->posts->getPost($app->requestUri);

    if (!$post) {
        $action = require(__DIR__ . '/404.php');
        $action($app);
        return;
    }

    $app->templateEngine->registerFunction('format_tags', function (array $tags) {

        return implode('', array_map(function ($tag) {
            return "<span class='c-tag'>{$tag}</span>";
        }, $tags));
    });

    echo $app->templateEngine->render('detail', [
        "post" => $post
    ]);
};
