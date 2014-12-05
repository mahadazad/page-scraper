<?php

namespace PageScrapper\Builder;

use PageScrapper\Page\PageInterface;

abstract class AbstractPageBuilder
{

	protected $page;
	protected $data = array();
	protected $dataConfig = array();

	public function __construct(PageInterface $page)
	{
		$this->page = $page;
	}

	public function getPage()
	{
		return $this->page;
	}

	public function setDataConfig(array $config)
	{
		$this->dataConfig = $config;
	}

	public function initializeData()
	{
		$this->getPage()->setData($this->data);
		return $this;
	}
	
	public function fetchData()
	{
		if (!empty($this->dataConfig)) {
			foreach ($this->dataConfig as $key => $value) {
				if (is_string($value)) { // get xpath result
					$xpath = $this->getPage()->getXpath();
					$this->data[ $key ] = $this->xpathResult($xpath, $value);
				}
				else if (is_callable($value)) { // run callback
					$this->data[ $key ] = call_user_func($value, $this->getPage());
				}
			}
		}
		return $this;
	}

	/**
	 * @param \DOMXpath $xpath
	 * @param string $query
	 * @return null|string|array
	 */
	protected function xpathResult($xpath, $query)
	{
		$xdata = array();
		$xresult = $xpath->query($query);
		$result = null;

		if ($xresult->length > 0) {
			foreach ($xresult as $node) {
				$xdata[] = $node->nodeValue;
			}

			$result = count($xdata) == 1 ? array_pop($xdata) : $xdata;
		}

		return !empty($result) ? $result : null;
	}

	public abstract function fetchPage();
	public abstract function initializeHtml();
	public abstract function initializeDomDocument();
	public abstract function initializeDomXpath();	

}