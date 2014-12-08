<?php

libxml_use_internal_errors(true);

include __DIR__ . '/../vendor/autoload.php';

use PageScraper\Builder\BuilderFactory;
use PageScraper\Director\PageBuilderDirector;

// returns the PageBuilderCollection
$builder = BuilderFactory::get(array(
    array(
        'url'         => 'https://news.ycombinator.com',
        'data_config' => array(
            'titles'  => '//td[@class="title"]//a/text()',
            'links'   => '//td[@class="title"]//a/@href',
        ),
    ),
//  ...
//  ...
//  you can add more url configs
//  ...
//  ...
));

// always use director to fetch the page
$director = new PageBuilderDirector($builder);

// returns PageBuilderCollection
$pages = $director->buildPage();

foreach ($pages as $page) {
    $data = $page->getData();

    echo '<pre>';
    print_r(array_combine(
        $data['titles'],
        $data['links']
    ));
    echo '</pre>';
}