<?php

namespace libs;

class Pagination
{
    public int $currentPage;
    public int $itemsOnPage;
    public int $totalItems;
    /**
     * @var false|float|int
     */
    private $countPages;
    private string $uri;

    public function __construct($page, $itemsOnPage, $totalItems)
    {
        $this->itemsOnPage = $itemsOnPage;
        $this->totalItems = $totalItems;
        $this->currentPage = $page;
        $this->countPages = $this->getCountPages();
        $this->uri = $this->getParams();
    }

    public function __toString()
    {
        if ($this->countPages > 1) {
            return $this->getHtmlPagination();
        } else {
            return '';
        }
    }

    public function getStart()
    {
        return ($this->currentPage - 1) * $this->itemsOnPage;
    }

    public function getCountPages(): int
    {
        return ceil($this->totalItems / $this->itemsOnPage) ?: 1;
    }

    public function getParams(): string
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $uri = $url[0] . '?';
        if (isset($url[1]) && $url[1] != '') {
            $params = explode('&', $url[1]);
            foreach ($params as $param) {
                if (!preg_match("#page=#", $param)) {
                    $uri .= "{$param}&amp;";
                }
            }
        }
        return $uri;
    }

    public function getHtmlPagination()
    {
        $back = null;
        $next = null;
        $page1right = null;
        $page1left = null;

        if ($this->currentPage > 1) {
            $back = "<li class='page-item'>
                        <a class='page-link' href='{$this->uri}page=" . 1 . "'>
                            <span aria-hidden='true'>&laquo;</span>
                        </a>
                     </li>";
        }

        if ($this->currentPage < $this->countPages) {
            $next = "<li class='page-item'>
                        <a class='page-link' href='{$this->uri}page=" . ($this->getCountPages()) . "'>
                            <span aria-hidden='true'>&raquo;</span>
                        </a>
                     </li>";
        }

        if ($this->currentPage - 1 > 0) {
            $page1left = "<li class='page-item'>
                           <a class='page-link' href='{$this->uri}page=" . ($this->currentPage - 1) . "'>"
                            . ($this->currentPage - 1)
                            . "</a></li>";
        }
        if ($this->currentPage + 1 <= $this->countPages) {
            $page1right = "<li class='page-item'>
                           <a class='page-link' href='{$this->uri}page=" . ($this->currentPage + 1) . "'>"
                . ($this->currentPage + 1)
                . "</a></li>";
        }

        return "<ul class='pagination'>" . $back . $page1left
            . "<li class='page-item active'><a class='page-link'>" . $this->currentPage . "</a></li>"
            . $page1right . $next . "</ul>";
    }

}