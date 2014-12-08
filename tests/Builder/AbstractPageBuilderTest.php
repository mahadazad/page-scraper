<?php

namespace PageScraper\Tests\Builder;
use PageScraper\Page\Page;
use PageScraper\Tests\Stub\PageBuilder as PageBuilderStub;

/**
* @author Muhammad Mahad Azad <mahadazad@gmail.com>
*/
class AbstractPageBuilderTest extends \PHPUnit_Framework_TestCase
{

	private $page;
	private $builder;
	private $doc;
	private $html;

	public function setUp()
	{
		$this->html = file_get_contents(__DIR__ . '/../Stub/page.htm');
	}

	public function testAbstract()
	{
		$this->page = $page = new Page('http://www.google.com/');
		$builder = $this->builder = $this->getMockForAbstractClass('PageScraper\Builder\AbstractPageBuilder');
		$builder->setPage($page);

        $builder->expects($this->once())
                ->method('fetchPage')
                ->will( $this->returnValue( $this->html ) );

        $builder->expects($this->once())
                ->method('initializeHtml')
                ->will( $this->returnCallback( array($this, 'initializeHtml') ) );

        $builder->expects($this->once())
                ->method('initializeDomDocument')
                ->will( $this->returnCallback( array($this, 'initializeDomDocument') ) );

        $builder->expects($this->once())
                ->method('initializeDomXpath')
                ->will( $this->returnCallback( array($this, 'initializeDomXpath') ) );

        $builder->setDataConfig(array(
        	'h1' => '//h1[@id="test-heading"]',
        	'p'  => function ($page) {
        		$val = $page->getXpath()->query('//p[@class="test-para"]')->item(0)->nodeValue;
        		return strpos($val, 'testing') > 0;
        	},
        ));
        $builder->fetchPage();
        $builder->initializeHtml();
        $builder->initializeDomDocument();
        $builder->initializeDomXpath();
        $builder->fetchData();
        $builder->initializeData();

        $this->assertEquals(array('h1' => 'Testing H1', 'p' => true), $page->getData());
	}


	public function initializeHtml()
	{
		$this->page->setHtml( $this->html );
	}

	public function initializeDomDocument()
	{
		$this->doc = new \DomDocument();
		$this->doc->loadHtml($this->html);
		$this->page->setDocument( $this->doc );
	}

	public function initializeDomXpath()
	{
		$this->page->setXpath( new \DOMXpath($this->doc) );
	}
}