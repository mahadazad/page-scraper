<?php

namespace PageScraper\Page;

use PageScraper\Page\Paginator\PaginatorInterface;

/**
* @author Muhammad Mahad Azad <mahadazad@gmail.com>
*/
interface PaginationInterface
{
    /**
     * @return int
     */
    public function getPageCount();

    /**
     * @return PaginatorInterface
     */
    public function getPaginator();
}
