<?php

namespace PageScraper\Builder;

use PageScraper\Page\Page;

/**
* @author Muhammad Mahad Azad <mahadazad@gmail.com>
*/
class BuilderFactory
{
    /**
     * @param  array                 $config
     *                                       takes an array of url and optional data_config pairs eg:
     *                                       array(
     *                                       array( // page config
     *                                       'url' => 'http://www.example.com',
     *                                       'data_config' => array(
     *                                       'key' => function($pageObj){ return value },
     *                                       'key' => 'xpath',
     *                                       )
     *                                       ),
     *                                       )
     * @return PageBuilderCollection
     */
    public static function get(array $config)
    {
        $builders = new PageBuilderCollection();

        if (!empty($config)) {
            foreach ($config as $page_config) {
                if (isset($page_config['url'])) {
                    $page = new Page($page_config['url']);
                    $builder = new PageBuilder($page);

                    if (isset($page_config['data_config'])) {
                        $builder->setDataConfig($page_config['data_config']);
                    }

                    $builders->add($builder);
                }
            }
        }

        return $builders;
    }
}
