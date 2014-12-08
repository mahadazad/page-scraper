<?php

namespace PageScraper\Page;

/**
* @author Muhammad Mahad Azad <mahadazad@gmail.com>
*/
class Page implements PageInterface
{
    /**
     * @var \DomDocument
     */
    protected $document;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $html;

    /**
     * @var \DOMXpath
     */
    protected $xpath;

    /**
     * @var array
     */
    protected $data = array();

    public function __construct($url = '')
    {
        $this->url = $url;
    }

    /**
     * @return string
     * @throws \RuntimeException if $this->url is not set
     */
    public function getUrl()
    {
        if (empty($this->url)) {
            throw new \RuntimeException('$this->url not set');
        }

        return $this->url;
    }

    /**
     * @param string
     * @throws \RuntimeException if $this->url is invalid
     * @todo Also validate url
     */
    public function setUrl($url)
    {
        if (empty($url)) {
            throw new \RuntimeException('$this->url is invalid');
        }

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
     * @throws \RuntimeException if $this->document not an instance of \DomDocument
     */
    public function getDocument()
    {
        if (!$this->document instanceof \DomDocument) {
            throw new \RuntimeException('$this->document must be an instance of \DomDocument');
        }

        return $this->document;
    }

    /**
     * @return \DOMXpath
     * @throws \RuntimeException if not an instance of \DOMXpath
     */
    public function getXpath()
    {
        if (!$this->xpath instanceof \DOMXpath) {
            throw new \RuntimeException('$this->xpath not an instance of \DOMXpath');
        }

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
        return $this->getXpath()->query($xpath_query);
    }
}
