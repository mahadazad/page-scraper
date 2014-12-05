<?php

namespace PageScrapper\Page\Paginator;

use PageScrapper\Page\PageInterface;
use PageScrapper\PageUtility;

class QueryPaginator extends AbstractPaginator
{

	protected $pageParam = 'page';
	protected $queryParams;
	protected $currentPageNumber;
	protected $nextPage = null;
	protected $previousPage = null;

	/**
	 * @param string
	 */
	public function setPageParam($param)
	{
		$this->pageParam = $param;
	}

	/**
	 * @return string
	 */
	public function getPageParam()
	{
		return $this->pageParam;
	}

	/**
	 * @return array
	 */
	protected function getParams()
	{
		if ($this->queryParams === null) {
			$this->queryParams = PageUtility::getQueryFromUrl($this->getCurrentPage()->getUrl());
		}

		return $this->queryParams;
	}

	/**
	 * @return int
	 */
	protected function getCurrentPageNumber()
	{
		if ($this->currentPageNumber === null) {
		 	if (($params = $this->getParams()) && isset($params[ $this->pageParam ])) {
		 		$this->currentPageNumber = $params[ $this->pageParam ];
			}
			else {
				$this->currentPageNumber = 1;
			}
		}

		return $this->currentPageNumber;
	}

	/**
	 * @return false|PageInterface
	 */
	public function getNextPage()
	{
		if ($this->nextPage === null && $this->getCurrentPageNumber() < $this->getPageCount()) {
			$page = $this->getCurrentPageNumber() + 1;
			$this->nextPage = $this->getPageWithPageParam($page); 
		}

		return $this->nextPage;
	}

	/**
	 * @return false|PageInterface
	 */
	public function getPreviousPage()
	{
		if ($this->previousPage === null && $this->getCurrentPageNumber() > 1) {
			$page = $this->getCurrentPageNumber() - 1;
			$this->previousPage = $this->getPageWithPageParam($page);
		}

		return $this->previousPage;

	}

	/**
	 * @param int
	 * @return PageInterface
	 */
	protected function getPageWithPageParam($page_number)
	{
			$url = PageUtility::replaceQueryInUrl(
						$this->getCurrentPage()->getUrl(),
						array($this->pageParam => $page_number)
					); 

			$class = get_class($this->getCurrentPage());
			$page = new $class;
			$page->setUrl($url);

			return $page;
	}

}