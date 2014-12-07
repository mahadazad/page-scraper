<?php

include __DIR__ . '/../vendor/autoload.php';

use PageScrapper\Client;

$client = new Client(array(
    'url'         => 'https://news.ycombinator.com',
    'data_config' => array(
        'titles' => '//td[@class="title"]//a/text()',
        'links' => '//td[@class="title"]//a/@href',
    ),
));

$page = $client->fetchPage();
$data = $page->getData();

echo '<pre>';
print_r(array_combine(
    $data['titles'],
    $data['links']
));
echo '</pre>';