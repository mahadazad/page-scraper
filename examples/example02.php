<?php

libxml_use_internal_errors(true);

include __DIR__ . '/../vendor/autoload.php';

use PageScrapper\Page\Page;
use PageScrapper\Builder\PageBuilder;
use PageScrapper\Director\PageBuilderDirector;


// create a page object
$page = new Page();
// set the url that needs to be fetched
$page->setUrl('https://news.ycombinator.com');


// builder contains the logic to fetch the remote page
// by default there is one builder right now
// which uses file_get_contents to fetch the remote pate
// we can add more builders which can use CURL or other
// technique to fetch the remote page
$builder = new PageBuilder($page);

// set the data that need to be retrieved from the remote page
$builder->setDataConfig(array(
    'titles' => '//td[@class="title"]//a/text()',
    'links' => '//td[@class="title"]//a/@href',
));

// use the director to instruct the builder to configure the page object
$director = new PageBuilderDirector($builder);
// finally fetch the remote page and configure the Page object
$director->buildPage();

// get the queried data
$data = $page->getData();


// display it
echo '<pre>';
print_r(array_combine(
    $data['titles'],
    $data['links']
));
echo '</pre>';