<?php

namespace PageScraper\Tests\Builder;
use PageScraper\Builder\PageBuilderCollection;
use PageScraper\Builder\PageBuilder;

/**
* @author Muhammad Mahad Azad <mahadazad@gmail.com>
*/
class PageBuilderCollectionTest extends \PHPUnit_Framework_TestCase
{

	public function testAdd()
	{
		$collection = new PageBuilderCollection();
		$builder = new PageBuilder();
		$collection[100] = $builder;

		$this->assertInstanceOf('PageScraper\Builder\PageBuilder', $collection[100]);
		$this->assertEquals(1, count($collection));
	}
	
	public function testRemove()
	{
		$collection = new PageBuilderCollection();
		$builder = new PageBuilder();
		$collection[1] = $builder;
		$collection[100] = $builder;


		unset($collection[100]);
		$this->assertEquals(false, isset($collection[100]));
		$this->assertEquals(1, count($collection));
	}
	
}