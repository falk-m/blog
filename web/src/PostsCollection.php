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

    public function getList(int $limit, int $offset, string $search = '', string $tag = '')
    {

        $Parsedown = new MarkDownParser();
        $baseDir =   $this->baseDir;
        $postFiles = glob("{$baseDir}/*/README.md");

        $posts = [];

        if (empty($search) && empty($tag)) {
            $listFiles = array_slice(array_reverse($postFiles), $offset, $limit);
        } else {
            $listFiles = array_reverse($postFiles);
        }

        foreach ($listFiles as $postFile) {

            $filePath = realpath($postFile);
            $markdownContent = file_get_contents($filePath);
            $headerRegex = '/^---([\s\S]*?)---/';
            preg_match($headerRegex, $markdownContent, $matches);
            $content = str_replace($matches[0], '', $markdownContent);
            $header = $matches[1];
            $url = dirname(substr(realpath($postFile), strlen($baseDir)));
            $header = Yaml::parse($header);

            if (str_starts_with($url, '.')) {
                continue;
            }

            if (!empty($tag)) {
                $postTags =  array_map('strtolower', $header['taxonomy']['tag'] ?? []);

                if (!in_array(strtolower($tag), $postTags)) {
                    continue;
                }
            }

            if (!empty($search)) {
                if (!str_contains(strtolower($markdownContent), strtolower($search))) {
                    continue;
                }
            }

            $Parsedown->setBaseImagePath($this->baseUrl . '/media' . $url . '/');
            $content = $Parsedown->text($content);
            $teaser = strip_tags($content);
            if (strlen($teaser) > 200) {
                $teaser = substr($teaser, 0, 197) . '...';
            }

            $posts[] = [
                "file" =>  $filePath,
                "url" => $this->baseUrl . $url,
                "header" => $header,
                "teaser" => $teaser
            ];
        }

        if (!empty($search) || !empty($tag)) {
            $posts = array_slice($posts, $offset, $limit);
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
