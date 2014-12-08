<?php

namespace PageScraper\Tests;
use PageScraper\Client;
use PageScraper\Tests\Stub\PageBuilder as PageBuilderStub;

/**
* @author Muhammad Mahad Azad <mahadazad@gmail.com>
*/
class ClientTest extends \PHPUnit_Framework_TestCase
{

	/**
     * @expectedException InvalidArgumentException
     */
	public function testConfigWithNoUrl()
	{
		$client = new Client(array());
	}

	public function testConfigWithUrl()
	{
		$client = new Client(array('url' => 'http://www.google.com/'));

		$this->assertInstanceOf('PageScraper\Page\PageInterface', $client->getPage());
		$this->assertInstanceOf('PageScraper\Builder\AbstractPageBuilder', $client->getBuilder());
		$this->assertInstanceOf('PageScraper\Director\PageBuilderDirectorInterface', $client->getDirector());
	}

	public function testBuildPage()
	{
		$url = 'http://www.google.com/';
		$client = new Client(array(
			'url' => $url,
			'data_config' => array(
				'test' => '//h1[@id="test-heading"]',
			),
			'builder' => new PageBuilderStub(),
		));

		$page = $client->fetchPage();
		$data = $page->getData();

		$this->assertInstanceOf('PageScraper\Page\PageInterface', $page);
		$this->assertEquals($url, $page->getUrl());
		$this->assertEquals('Testing H1', $data['test']);
		$this->assertInstanceOf('PageScraper\Tests\Stub\PageBuilder', $client->getBuilder());
	}

}