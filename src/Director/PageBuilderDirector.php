<?php

namespace PageScrapper\Director;

use PageScrapper\Builder\AbstractPageBuilder;
use PageScrapper\Builder\PageBuilderCollection;

class PageBuilderDirector implements PageBuilderDirectorInterface
{
	protected $builder;

	public function __construct($builder)
	{
		if (!$builder instanceof AbstractPageBuilder && !$builder instanceof PageBuilderCollection) {
			throw new \InvalidArgumentException('$builder must be an instance of AbstractPageBuilder or PageBuilderCollection');
		}

		$this->builder = $builder;
	}

	public function buildPage()
	{
		if ( !$this->builder instanceof PageBuilderCollection ) {
			return $this->process($this->builder);
		}

		$pages = array();
		foreach ($this->builder as $builder) {
			$pages[] = $this->process($builder);
		}
		return $pages;
	}

	protected function process(AbstractPageBuilder $builder)
	{
		return $builder->fetchPage()
					   ->initializeHtml()
					   ->initializeDomDocument()
					   ->initializeDomXpath()
					   ->fetchData()
					   ->initializeData()
					   ->getPage();
	}

}