<?php

namespace app;

use League\Plates\Engine;

class Blog
{
    public string $baseUrl;
    public array $config;
    public PostsCollection $posts;
    public string $requestUri;
    public Engine $templateEngine;

    public function __construct()
    {
        $this->baseUrl = substr(str_replace('\\', '/', realpath(dirname(__FILE__, 3))), strlen(str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']))));
        $this->config = require(dirname(__DIR__) . '/config.php');
        $this->posts = new PostsCollection($this->config['posts_dir'], $this->baseUrl);
        $this->requestUri = substr($_SERVER['REQUEST_URI'], strlen($this->baseUrl));
        $this->requestUri = current(explode('?', $this->requestUri));

        $this->templateEngine = new Engine(dirname(__DIR__) . '/views');
        $this->templateEngine->addData(['baseUrl' => $this->baseUrl]);
    }
}
