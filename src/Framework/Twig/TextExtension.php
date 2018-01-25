<?php

namespace Framework\Twig;

class TextExtension extends \Twig_Extension
{


    public function getFilters()
    {
        return[
            new \Twig_SimpleFilter('excerpt', [$this,'excerpt'])
        ];
    }

    /**
     * @param string $content
     * @param int $maxLenght
     * @return string
     */
    public function excerpt(string $content, int $maxLenght = 200):string
    {
        if (mb_strlen($content)>$maxLenght) {
            $excerpt = mb_substr($content, 0, $maxLenght);

            $lastSpace = mb_strrpos($excerpt, ' ');
            return mb_substr($excerpt, 0, $lastSpace)."...";
        }
        return $content;
    }
}
