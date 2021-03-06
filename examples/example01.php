<?php

libxml_use_internal_errors(true);

include __DIR__ . '/../vendor/autoload.php';

use PageScraper\Client;

// the most simpliest way to fetch the data is to use the Client
$client = new Client(array(
    // the html/xml that we are interested in
    'url'         => 'https://news.ycombinator.com',
    // the data we are interested in
    'data_config' => array(
        'titles' => '//td[@class="title"]//a/text()', // the xpath query
        'links' => '//td[@class="title"]//a/@href', // the xpath query
        'side_links' => array('css' => '.title .comhead'), // using css selector
    ),
));

// fetch the data, and get the Page object
$page = $client->fetchPage();
// get the desired data
$data = $page->getData();

// print the data
echo '<pre>';
print_r($data);
echo '</pre>';