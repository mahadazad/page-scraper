Page Scrapper
=============

Easy to use page scrapper with just few lines of code. Scrap data from any website using xpath.

Intoduction:
============

The easiest way to parse data from a valid xml/html page is to use XPath queries. But the method of fetching
the remote data can vary e.g. using simple `file_get_contents` function which uses PHP Streams to fetch the remote
page, `CURL` can be used, the famous `Guzzle` library can be used. To decouple the final product i.e. `Page` from the
remote page fetching logic and to avoid leaving the `Page` object in an unstable state I have used the Builder pattern.
The `Page` object is passed to the Builder object which contains the logic for fetching the remote page, then the
builder is passed to the director object which tells the builder how to configure the `Page` object. In a nutshell:

```php
$page = new Page('https://news.ycombinator.com');
$builder = new PageBuilder($page);
$builder->setDataConfig(array(
    'titles' => '//td[@class="title"]//a/text()',
    'links' => '//td[@class="title"]//a/@href',
));
$director = new PageBuilderDirector($builder);
$director->buildPage();
$data = $page->getData();
```

Using Client Class To Make Things Easier:
=========================================
To avoid the boilerplate work you can use `Client` class to make life easy:

```php
$client = new Client(array(
    'url'         => 'https://news.ycombinator.com',
    'data_config' => array(
        'titles' => '//td[@class="title"]//a/text()', // the xpath query
        'links' => '//td[@class="title"]//a/@href', // the xpath query
    ),
));

$page = $client->fetchPage();
$data = $page->getData();

/*
  prints:
   array (
    'titles' => array(
        'title one from the remote page',
        'title two from the remote page',
        'title three from the remote page',
        // so on...
    ),
    'links' => array(
        'http://www.example.com/one',
        'http://www.example.com/two',
        'http://www.example.com/three',
        // so on...
    ),
  )
*/
print_r($data);
```

Having said that, you can also set your own `builders` and `directors` using the client's setter methods. Please see the class defination for the docs.

Advanced Parsing Data:
======================
the `data_config` can contain `key` => `value` pairs. Where the value can be a valid xpath query or a callback which recieves the configured `Page` object which you can utilize for advanced parsing and the `key` holds the parsed result. E.g:

```php
$client = new Client(array(
    'url'         => 'https://news.ycombinator.com',
    'data_config' => array(
        'titles' => '//td[@class="title"]//a/text()', // the xpath query
        'links' => function ($page) {
            return $page->getXpath()   // further parse the data if required
                        ->query('//td[@class="title"]//a/@href')->item(0)->nodeValue;
        },
    ),
));

$page = $client->fetchPage();
$data = $page->getData();
```

Installation:
=============
use composer to install the library, in your composer.json:

```json
{
    "require": {
        "mahadazad/page-scrapper": "dev-master"
    }
}
```

or run

`php composer.phar require "mahadazad/page-scrapper":"dev-master"`
