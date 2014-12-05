<?php

namespace PageScrapper\Page\Paginator;

use PageScrapper\Page\PageInterface;

abstract class AbstractPaginator implements PaginatorInterface
{
	
	protected $basePageUrl;
	protected $currentPage;
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
	 */
	public function getBasePageUrl(){
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
	 */
	public function getCurrentPage()
	{
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