<?php

namespace PageScraper\Page\Paginator;

use PageScraper\Page\PageInterface;

/**
* @author Muhammad Mahad Azad <mahadazad@gmail.com>
*/
abstract class AbstractPaginator implements PaginatorInterface
{
    /**
     * @var string
     */
    protected $basePageUrl;

    /**
     * @var PageInterface
     */
    protected $currentPage;

    /**
     * @var int
     */
    protected $pageCount;

    /**
     * @param string $url
     */
    public function setBasePageUrl($url)
    {
        $this->basePageUrl = $url;
    }

    /**
     * @return string
     * @throws \RuntimeException if basePageUrl not set
     */
    public function getBasePageUrl()
    {
        if (empty($this->basePageUrl)) {
            throw new \RuntimeException('$this->basePageUrl not set');
        }

        return $this->basePageUrl;
    }

    /**
     * @return PageInterface
     */
    public function setCurrentPage(PageInterface $page)
    {
        $this->currentPage = $page;
    }

    /**
     * @return PageInterface
     * @throws \RuntimeException if $this->currentPage not an instance of PageScraper\Page\PageInterface
     */
    public function getCurrentPage()
    {
        if (!$this->currentPage instanceof PageInterface) {
            throw new \RuntimeException('$this->currentPage must be instance of PageScraper\Page\PageInterface');
        }

        return $this->currentPage;
    }

    /**
     * @param int
     */
    public function setPageCount($count)
    {
        $this->pageCount = $count;
    }

    /**
     * @return int
     */
    public function getPageCount()
    {
        return $this->pageCount;
    }
}
