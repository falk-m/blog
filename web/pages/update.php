<?php

use app\Blog;
use app\FilesCollection;

return function (Blog $app) {
    header("Content-Type: text/plain");
    $output = "";
    $code = "";
    $res = exec("cd .. && git pull", $output, $code);

    echo "Result:\n";
    print_r($res);
    echo "\n\n";
    echo "Output:\n";
    print_r($output);
    echo "\n\n";
    echo "Code:\n";
    print_r($code);
};
