<?php

namespace PageScraper\Page\Paginator;

use PageScraper\Page\PageInterface;

/**
* @author Muhammad Mahad Azad <mahadazad@gmail.com>
*/
interface PaginatorInterface
{
    /**
     * @param string $url
     */
    public function setBasePageUrl($url);

    /**
     * @return string
     */
    public function getBasePageUrl();

    /**
     * @return PageInterface
     */
    public function setCurrentPage(PageInterface $page);

    /**
     * @return PageInterface
     */
    public function getCurrentPage();

    /**
     * @return null|PageInterface
     */
    public function getNextPage();

    /**
     * @return null|PageInterface
     */
    public function getPreviousPage();

    /**
     * @param int
     */
    public function setPageCount($count);

    /**
     * @return int
     */
    public function getPageCount();
}
