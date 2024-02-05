<?php

use app\Blog;
use Bitverse\Identicon\Identicon;
use Bitverse\Identicon\Color\Color;
use Bitverse\Identicon\Generator\PixelsGenerator;
use Bitverse\Identicon\Generator\RingsGenerator;
use Bitverse\Identicon\Preprocessor\MD5Preprocessor;


return function (Blog $app) {

    $generator = new RingsGenerator();
    $generator->setBackgroundColor(Color::parseHex('#EEEEEE'));

    $identicon = new Identicon(new MD5Preprocessor(), $generator);

    $icon = $identicon->getIcon($app->requestUri);

    header("Content-type: image/svg+xml");
    echo $icon;
};
