<?php

namespace PageScraper\Tests\Stub;

use PageScraper\Builder\PageBuilder as PageBuilderOrignal;

/**
* @author Muhammad Mahad Azad <mahadazad@gmail.com>
*/
class PageBuilder extends PageBuilderOrignal
{
	/**
	 * @return $this
	 */
	public function fetchPage()
	{
		$this->html = file_get_contents( __DIR__ . '/page.htm' );

		return $this;
	}

}