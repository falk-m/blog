<?php

use app\Blog;

return function (Blog $app) {

    $page = intval($_GET['page'] ?? '1');
    $limit = 15;
    $offset = ($page - 1) * $limit;
    $posts = $app->posts->getList($limit, $offset);

    echo $app->templateEngine->render('home', [
        "posts" => $posts,
        "page" => $page,
        "limit" => $limit
    ]);
};
