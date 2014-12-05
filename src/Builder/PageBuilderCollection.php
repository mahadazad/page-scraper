<?php

namespace PageScrapper\Builder;
use PageScrapper\Page\PageInterface;

class PageBuilderCollection implements \IteratorAggregate, \Countable
{

	protected $builders;
	protected $hashMap = array();

	/**
	 * @param array $builders (optional)
	 *
	 * Takes array of AbstractPageBuilder or PageInterface, in case of
	 * PageInterface it instantiate a default builder. 
	 */
	public function __construct($builders = null)
	{
		if (is_array($builders) && !empty($builders)) {
			foreach($builders as $builder) {
				if ($builder instanceof PageInterface) {
					$builder = new PageBuilder($builder);
				}

				$this->add($builder);
			}
		}
	}

	/**
	 * @param AbstractPageBuilder $builder
	 */
	public function add(AbstractPageBuilder $builder)
	{
		$this->builders[] = $builder;
		end($this->builders);
		$this->hashMap[ spl_object_hash($builder) ] = key($this->builders);
	}

	/**
	 * @param int|AbstractPageBuilder $index
	 */
	public function remove($index)
	{
		if ($builder instanceof AbstractPageBuilder) {
			$hash = spl_object_hash($builder);
			if (array_key_exists($hash, $this->builders)) {
				$index = $this->builders[ $hash ];
			}
		}
		
		unset($this->builders[ $index ]);
	}

	/**
	 * @return \Iterator
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->builders);
	}

	/**
	 * @return int
	 */
	public function count()
	{
		return count($this->builders);
	}

}