<?php

namespace PageScraper\Page;

/**
* @author Muhammad Mahad Azad <mahadazad@gmail.com>
*/
interface PageInterface
{
    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param string
     */
    public function setUrl($url);

    /**
     * @return string
     */
    public function getHtml();

    /**
     * @param string
     */
    public function setHtml($html);

    /**
     * @param \DomDocument
     */
    public function setDocument(\DomDocument $document);

    /**
     * @return \DomDocument
     */
    public function getDocument();

    /**
     * @return \DOMXpath
     */
    public function getXpath();

    /**
     * @return \DOMXpath
     */
    public function setXpath(\DOMXpath $xpath);

    /**
     * @return array
     */
    public function getData();

    /**
     * @param array $data
     */
    public function setData($data);
}
