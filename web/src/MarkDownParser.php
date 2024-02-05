<?php

namespace app;

use Parsedown;

class MarkDownParser extends Parsedown
{

    private $baseImagePath = '';

    public function setBaseImagePath($baseImagePath)
    {
        $this->baseImagePath = $baseImagePath;
    }


    protected function inlineLink($Excerpt)
    {
        $link = parent::inlineLink($Excerpt);

        if (!isset($link)) {
            return null;
        }

        $href = $link['element']['attributes']['href'] ?? '';

        if (!isset(parse_url($href)['host'])) {
            $href =  $this->baseImagePath . $href;
        }

        $link['element']['attributes']['href'] = $href;

        return $link;
    }
}
