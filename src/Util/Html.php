<?php

namespace imorland\PostDecontaminator\Util;

use imorland\PostDecontaminator\PostDecontaminatorModel;

class Html
{
    public static function render($html, PostDecontaminatorModel $page)
    {
        if (strpos($html, '@include(') !== false) {
            $html = preg_replace_callback(
                '/\@include\([\"\']?([\.\/\w\s]+)[\"\']?\)/mi',
                function ($matches) use ($page) {
                    $base = app('path.profanities');
                    $path = trim($matches[1], " \r\n\t\f/.");
                    $path = $base.DIRECTORY_SEPARATOR.$path;
                    if (substr($path, -4) !== '.php') {
                        $path .= '.php';
                    }
                    $path = realpath($path);
                    if (!empty($path) && strpos($path, $base) === 0 && is_readable($path)) {
                        $view = app('view')->file($path);
                        $view->page = $page;

                        return $view->render();
                    }

                    return $matches[0];
                },
                $html
            );
        }

        return $html;
    }
}
