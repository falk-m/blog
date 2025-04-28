<?php

use Kirby\Toolkit\Config;

return function ($kirby, $site, $pages, $page) {
    $api = Config::get('weather-api');

    $result = file_get_contents($api);
    $weather = json_decode($result, true);

    return [
        'temperature' => $weather['temperature']
    ];
};
