<?php

namespace PageScrapper\Builder;
use PageScrapper\Page\Page;

/*

	array(
		array( // page config
			'url' => 'http://www.example.com',
			'data_config' => array(
				'key' => function($pageObj){ return value },
				'key' => 'xpath',
			)
		),
	)

*/


class BuilderFactory
{
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