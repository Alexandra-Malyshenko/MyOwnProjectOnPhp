<?php

namespace libs;

class Sorting
{
    public function getParams(): string
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $uri = $url[0] . '?';
        if (isset($url[1]) && $url[1] != '') {
            $params = explode('&', $url[1]);
            foreach ($params as $param) {
                if (!preg_match("#sort=#", $param)) {
                    $uri .= "{$param}&amp;";
                }
            }
        }
        return $uri;
    }

    public function __toString()
    {
        return $this->getHtmlPagination();
    }

    public function getHtmlPagination()
    {
        return "<ul class='dropdown-menu dropdown-menu-end' aria-labelledby='dropdownSort' style='text-align: right'>
                   <li><a class='dropdown-item' href='{$this->getParams()}sort=price-ASC'>&#8593; возрастанию цены</a></li>
                   <li><a class='dropdown-item' href='{$this->getParams()}sort=price-DESC'>&#8595; убыванию цены</a></li>
                   <li><a class='dropdown-item' href='{$this->getParams()}sort=title-ASC'>алфавиту</a></li>
                </ul>";
    }
}