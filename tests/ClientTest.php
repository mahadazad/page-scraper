<?php

namespace PageScrapper\Tests;
use PageScrapper\Client;
use PageScrapper\Tests\Stub\PageBuilder as PageBuilderStub;

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

		$this->assertInstanceOf('PageScrapper\Page\PageInterface', $client->getPage());
		$this->assertInstanceOf('PageScrapper\Builder\AbstractPageBuilder', $client->getBuilder());
		$this->assertInstanceOf('PageScrapper\Director\PageBuilderDirectorInterface', $client->getDirector());
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

		$this->assertInstanceOf('PageScrapper\Page\PageInterface', $page);
		$this->assertEquals($url, $page->getUrl());
		$this->assertEquals('Testing H1', $data['test']);
		$this->assertInstanceOf('PageScrapper\Tests\Stub\PageBuilder', $client->getBuilder());
	}

}