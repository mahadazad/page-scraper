<?php

namespace PageScrapper\Page;
use PageScrapper\Page\Paginator\PaginatorInterface;

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