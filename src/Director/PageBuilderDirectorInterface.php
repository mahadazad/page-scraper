<?php

namespace PageScraper\Director;

use PageScraper\Builder\AbstractPageBuilder;

/**
* @author Muhammad Mahad Azad <mahadazad@gmail.com>
*/
interface PageBuilderDirectorInterface
{
    /**
     * @param AbstractPageBuilder|PageBuilderCollection $builder
     */
    public function setBuilder($builder);

    /**
     * @return AbstractPageBuilder|PageBuilderCollection
     */
    public function getBuilder();

    /**
     * @return Page|Page[]
     */
    public function buildPage();
}
