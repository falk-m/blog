<?php

use app\Blog;

return function (Blog $app) {
    http_response_code(404);
    echo $app->templateEngine->render('404');
};
