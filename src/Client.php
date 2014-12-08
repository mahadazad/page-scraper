<?php

namespace PageScraper;

use PageScraper\Builder\AbstractPageBuilder;
use PageScraper\Builder\PageBuilder;
use PageScraper\Director\PageBuilderDirectorInterface;
use PageScraper\Director\PageBuilderDirector;
use PageScraper\Page\PageInterface;
use PageScraper\Page\Page;

/**
* @author Muhammad Mahad Azad <mahadazad@gmail.com>
*/
class Client
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var data_config
     */
    protected $data_config = array();

    /**
     * @var PageInterface
     */
    protected $page;

    /**
     * @var AbstractPageBuilder
     */
    protected $builder;

    /**
     * @var PageBuilderDirectorInterface
     */
    protected $director;

    /**
     * @param array $config
     *                      - 'url'         => accepts string url
     *                      - 'data_config' => array of key => value pairs which maps to either xpath query
     *                                         or a callback which recieves PageInterface object which can be quried
     *                                         and return the required result
     *                      - 'director'    => optional config to set director object, defaults to:
     *                                         PageScraper\Director\PageBuilderDirector
     *                      - 'builder'     => optional config to set builder object, defaults to:
     *                                         PageScraper\Builder\PageBuilder
     *                      - 'page'        => optional config to set page object, defaults to:
     *                                         PageScraper\Page\Page
     *
     */
    public function __construct(array $config)
    {
        if (!isset($config['url'])) {
            throw new \InvalidArgumentException('"url" key must be set');
        }

        if (isset($config['data_config'])) {
            if (is_array($config['data_config'])) {
                $this->data_config = $config['data_config'];
            } else {
                throw new \InvalidArgumentException('"data_config" must be an array');
            }
        }

        if (isset($config['director'])) {
            $this->setDirector($config['director']);
        } else {
            $this->setDirector(new PageBuilderDirector());
        }

        if (isset($config['builder'])) {
            $this->setBuilder($config['builder']);
        } else {
            $this->setBuilder(new PageBuilder());
        }

        if (isset($config['page'])) {
            $this->setPage($config['page']);
        } else {
            $this->setPage(new Page());
        }

        $this->url = $config['url'];
    }

    /**
     * @param PageInterface $page
     */
    public function setPage(PageInterface $page)
    {
        $this->page = $page;
    }

    /**
     * @return PageInterface
     * @throws \RuntimeException if $this->page is not an instance of PageInterface
     */
    public function getPage()
    {
        if ($this->page == null) {
            throw new \RuntimeException('"page" not set');
        }

        return $this->page;
    }

    /**
     * @param AbstractPageBuilder $builder
     */
    public function setBuilder(AbstractPageBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @return AbstractPageBuilder
     * @throws \RuntimeException   if $this->builder is not set
     */
    public function getBuilder()
    {
        if ($this->builder == null) {
            throw new \RuntimeException('"builder" not set');
        }

        return $this->builder;
    }

    /**
     * @param PageBuilderDirectorInterface $director
     */
    public function setDirector(PageBuilderDirectorInterface $director)
    {
        $this->director = $director;
    }

    /**
     * @return PageBuilderDirectorInterface
     * @throws \RuntimeException            if $this->director is not set
     */
    public function getDirector()
    {
        if ($this->director == null) {
            throw new \RuntimeException('"director" not set');
        }

        return $this->director;
    }

    /**
     * @return PageInterface|PageInterface[]
     */
    public function fetchPage()
    {
        $this->getPage()->setUrl($this->url);
        $this->getBuilder()->setPage($this->page);
        $this->getBuilder()->setDataConfig($this->data_config);
        $this->getDirector()->setBuilder($this->builder);

        return $this->getDirector()->buildPage();
    }
}
