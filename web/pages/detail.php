<?php

use app\Blog;

return function (Blog $app) {

    $post = $app->posts->getPost($app->requestUri);

    if (!$post) {
        $action = require(__DIR__ . '/404.php');
        $action($app);
        return;
    }

    echo $app->templateEngine->render('detail', [
        "post" => $post
    ]);
};
