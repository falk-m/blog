<?php

use app\Blog;

return function (Blog $app) {

    $page = intval($_GET['page'] ?? '1');
    $limit = 15;
    $offset = ($page - 1) * $limit;
    $search = $_GET['search'] ?? '';
    $tag = $_GET['tag'] ?? '';
    $posts = $app->posts->getList($limit, $offset, $search, $tag);

    $app->templateEngine->registerFunction('format_tags', function (array $tags) use ($app) {
        return implode('', array_map(function ($tag) use ($app) {
            return "<a class='c-tag' href='{$app->baseUrl}?tag={$tag}'>{$tag}</a>";
        }, $tags));
    });

    echo $app->templateEngine->render('home', [
        "posts" => $posts,
        "page" => $page,
        "limit" => $limit
    ]);
};
