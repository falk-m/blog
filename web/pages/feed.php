<?php

use app\Blog;

return function (Blog $app) {

    $host = 'https://www.falk-m.de';
    $limit = 20;
    $offset = 0;
    $search = '';
    $tag = $_GET['tag'] ?? '';
    $posts = $app->posts->getList($limit, $offset, $search, $tag);

    header('Content-Type: application/xml; charset=utf-8');

    $xml = new DOMDocument('1.0', 'utf-8');
    $xml->formatOutput = true;

    $rss = $xml->createElement('rss');
    $rss->setAttribute('version', '2.0');
    $xml->appendChild($rss);

    $channel = $xml->createElement('channel');
    $rss->appendChild($channel);

    // Head des Feeds    
    $head = $xml->createElement('title', 'falk-m.de Feed');
    $channel->appendChild($head);

    $head = $xml->createElement('description', 'News, Snippets, Slides, ....');
    $channel->appendChild($head);

    $head = $xml->createElement('language', 'en');
    $channel->appendChild($head);

    $head = $xml->createElement('link', $host . $app->baseUrl);
    $channel->appendChild($head);

    $dateObject = DateTime::createFromFormat('Y-m-d', $posts[0]["header"]["date"]);
    $head = $xml->createElement('lastBuildDate', $dateObject->format(DateTime::RSS));
    $channel->appendChild($head);

    $encodeUtf8 = function (string $input) {
        return mb_convert_encoding($input, "UTF-8", "ISO-8859-1");
    };

    $formatTags = function (array $tags) {
        return implode('', array_map(function ($tag) {
            return "[{$tag}]";
        }, $tags));
    };

    foreach ($posts as $post) {
        $item = $xml->createElement('item');
        $channel->appendChild($item);

        $data = $xml->createElement('title', $encodeUtf8($formatTags($post['header']['taxonomy']['tag'] ?? []) . ' ' . $post["header"]["title"] ?? ""));
        $item->appendChild($data);

        $data = $xml->createElement('description', $encodeUtf8($post["teaser"]));
        $item->appendChild($data);

        $data = $xml->createElement('link', $host . $post['url']);
        $item->appendChild($data);

        $dateObject = DateTime::createFromFormat('Y-m-d', $post["header"]["date"]);
        $data = $xml->createElement('pubDate', $dateObject->format(DateTime::RSS));
        $item->appendChild($data);

        $data = $xml->createElement('guid', $post['url']);
        $item->appendChild($data);
    }

    echo $xml->saveXML();
};
