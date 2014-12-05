<?php

namespace PageScrapper\Page;

class Page implements PageInterface
{

	protected $document;
	protected $url;
	protected $html;
	protected $xpath;
	protected $data = array();

	public function __construct($url = '')
	{
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @param string
	 */
	public function setUrl($url)
	{
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	public function getHtml()
	{
		return $this->html;
	}

	/**
	 * @param string
	 */
	public function setHtml($html)
	{
		$this->html = $html;
	}

	/**
	 * @param \DomDocument
	 */
	public function setDocument(\DomDocument $document)
	{
		$this->document = $document;
	}

	/**
	 * @return \DomDocument
	 */
	public function getDocument()
	{
		return $this->document;
	}

	/**
	 * @return \DOMXpath
	 */
	public function getXpath()
	{
		return $this->xpath;
	}

	/**
	 * @param array $data
	 */
	public function setData($data)
	{
		$this->data = $data;
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * @param \DOMXpath
	 */
	public function setXpath(\DOMXpath $xpath)
	{
		$this->xpath = $xpath;
	}

	/**
	 * @param string $xpath_query 
	 */
	protected function query($xpath_query)
	{
		return $this->xpath->query($xpath_query);
	}

}