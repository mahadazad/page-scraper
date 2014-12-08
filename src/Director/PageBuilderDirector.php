<?php

namespace PageScraper\Director;

use PageScraper\Builder\AbstractPageBuilder;
use PageScraper\Builder\PageBuilderCollection;

/**
* @author Muhammad Mahad Azad <mahadazad@gmail.com>
*/
class PageBuilderDirector implements PageBuilderDirectorInterface
{
    /**
     * @var AbstractPageBuilder
     */
    protected $builder;

    /**
     * @param  null|AbstractPageBuilder|PageBuilderCollection $builder
     * @throws \InvalidArgumentException                      if builder is not null|AbstractPageBuilder|PageBuilderCollection
     */
    public function __construct($builder = null)
    {
        if ($builder !== null) {
            $this->setBuilder($builder);
        }
    }

    /**
     * @param  AbstractPageBuilder|PageBuilderCollection $builder
     * @throws \InvalidArgumentException                 if builder is not AbstractPageBuilder|PageBuilderCollection
     */
    public function setBuilder($builder)
    {
        if (!$builder instanceof AbstractPageBuilder && !$builder instanceof PageBuilderCollection) {
            throw new \InvalidArgumentException('$builder must be an instance of AbstractPageBuilder or PageBuilderCollection');
        }

        $this->builder = $builder;
    }

    /**
     * @return AbstractPageBuilder|PageBuilderCollection $builder
     * @throws \InvalidArgumentException                 if builder is not AbstractPageBuilder|PageBuilderCollection
     */
    public function getBuilder()
    {
        if (!$this->builder instanceof AbstractPageBuilder && !$this->builder instanceof PageBuilderCollection) {
            throw new \InvalidArgumentException('$builder must be an instance of AbstractPageBuilder or PageBuilderCollection');
        }

        return $this->builder;
    }

    /**
     * @return Page|Page[]
     * @throws \RuntimeException if builder is not an instance of AbstractPageBuilder or PageBuilderCollection
     */
    public function buildPage()
    {
        if (!$this->getBuilder() instanceof PageBuilderCollection) {
            return $this->process($this->builder);
        }

        $pages = array();
        foreach ($this->getBuilder() as $builder) {
            $pages[] = $this->process($builder);
        }

        return $pages;
    }

    /**
     * @param  AbstractPageBuilder $builder
     * @return Page
     */
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
