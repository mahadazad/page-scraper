<?php

namespace PageScraper\Builder;

use PageScraper\Page\PageInterface;
use Symfony\Component\CssSelector\CssSelector;

/**
* @author Muhammad Mahad Azad <mahadazad@gmail.com>
*/
abstract class AbstractPageBuilder
{
    /**
     * @var AbstractPageBuilder
     */
    protected $page;

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var array
     */
    protected $dataConfig = array();

    /**
     * @param PageInterface $page
     */
    public function __construct(PageInterface $page = null)
    {
        $this->page = $page;
    }

    /**
     * @param PageInterface
     */
    public function setPage(PageInterface $page)
    {
        return $this->page = $page;
    }

    /**
     * @return PageInterface
     *
     * @throws \RuntimeException if page property not set
     */
    public function getPage()
    {
        if (!$this->page instanceof PageInterface) {
            throw new \RuntimeException(__CLASS__.'::$page is not an instance of PageScraper\Page\PageInterface');
        }

        return $this->page;
    }

    /**
     * @param array $config
     */
    public function setDataConfig(array $config)
    {
        $this->dataConfig = $config;
    }

    /**
     * @return $this
     */
    public function initializeData()
    {
        $this->getPage()->setData($this->data);

        return $this;
    }

    /**
     * @return $this
     */
    public function fetchData()
    {
        if (!empty($this->dataConfig)) {
            foreach ($this->dataConfig as $key => $value) {
                switch (1) {
                    case is_array($value) && strtolower(key($value)) == 'css': // css
                        $value = CssSelector::toXpath(current($value));
                    case is_string($value): // xpath
                        $xpath = $this->getPage()->getXpath();
                        $this->data[ $key ] = $this->xpathResult($xpath, $value);
                        break;
                    case is_callable($value): // calback funtion
                        $this->data[ $key ] = call_user_func($value, $this->getPage());
                        break;
                }
            }
        }

        return $this;
    }

    /**
     * @param  \DOMXpath         $xpath
     * @param  string            $query
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

    /**
     * @return $this
     */
    abstract public function fetchPage();

    /**
     * @return $this
     */
    abstract public function initializeHtml();

    /**
     * @return $this
     */
    abstract public function initializeDomDocument();

    /**
     * @return $this
     */
    abstract public function initializeDomXpath();
}
