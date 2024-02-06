<?php

namespace app;

use app\MarkDownParser;
use Symfony\Component\Yaml\Yaml;

class PostsCollection
{
    private string $baseDir;
    private string $baseUrl;

    public function __construct(string $baseDir, string $baseUrl)
    {
        $this->baseDir = $baseDir;
        $this->baseUrl = $baseUrl;
    }

    public function getList(int $limit, int $offset)
    {

        $Parsedown = new MarkDownParser();
        $baseDir =   $this->baseDir;
        $postFiles = glob("{$baseDir}/*/README.md");

        $posts = [];

        $listFiles = array_slice(array_reverse($postFiles), $offset, $limit);

        foreach ($listFiles as $postFile) {

            $filePath = realpath($postFile);
            $markdownContent = file_get_contents($filePath);
            $headerRegex = '/^---([\s\S]*?)---/';
            preg_match($headerRegex, $markdownContent, $matches);
            $content = str_replace($matches[0], '', $markdownContent);
            $header = $matches[1];
            $url = dirname(substr(realpath($postFile), strlen($baseDir)));

            $Parsedown->setBaseImagePath($this->baseUrl . '/media' . $url . '/');
            $content = $Parsedown->text($content);
            $teaser = strip_tags($content);
            if (strlen($teaser) > 200) {
                $teaser = substr($teaser, 0, 197) . '...';
            }

            $posts[] = [
                "file" =>  $filePath,
                "url" => $this->baseUrl . $url,
                "header" => Yaml::parse($header),
                "teaser" => $teaser
            ];
        }

        return $posts;
    }

    public function getPost(string $uri)
    {
        $filePath = $this->baseDir . '/' . $uri . '/README.md';

        if (!file_exists($filePath)) {
            return null;
        }

        $markdownContent = file_get_contents($filePath);
        $headerRegex = '/^---([\s\S]*?)---/';
        preg_match($headerRegex, $markdownContent, $matches);
        $content = str_replace($matches[0], '', $markdownContent);
        $header = $matches[1];

        $Parsedown = new MarkDownParser();
        $Parsedown->setBaseImagePath($this->baseUrl . '/media' . $uri . '/');
        $content = $Parsedown->setBreaksEnabled(true)->text($content);

        $files = glob(dirname($filePath) . '/*');
        $files = array_map(function ($f) {
            return basename($f);
        }, $files);

        return [
            "header" => Yaml::parse($header),
            "content" => $content,
            "files" => $files,
        ];
    }
}
