<?php

namespace PageScraper\Builder;

use PageScraper\Page\PageInterface;

/**
* @author Muhammad Mahad Azad <mahadazad@gmail.com>
*/
class PageBuilderCollection implements \ArrayAccess, \IteratorAggregate, \Countable
{
    /**
     * @var AbstractPageBuilder[]
     */
    protected $builders = array();

    /**
     * @var array
     */
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
            foreach ($builders as $builder) {
                if ($builder instanceof PageInterface) {
                    $builder = new PageBuilder($builder);
                }

                $this->add($builder);
            }
        }
    }

    /**
     * @param  AbstractPageBuilder $builder
     * @throws \RuntimeException   if non integer index provided
     */
    public function add(AbstractPageBuilder $builder, $index = null)
    {
        $hash = spl_object_hash($builder);

        if (!is_int($index) && $index !== null) {
            throw new \RuntimeException('only integer indices allowed for PageBuilderCollection');
        }

        if (!is_int($index)) {
            $this->builders[] = $builder;
            end($this->builders);
            $this->hashMap[ $hash ] = key($this->builders);
        } else {
            $this->builders[ $index ] = $builder;
            $this->hashMap[ $hash ] = $index;
        }
    }

    /**
     * @param int|AbstractPageBuilder $index
     */
    public function remove($index)
    {
        if ($index instanceof AbstractPageBuilder) {
            $hash = spl_object_hash($index);
            if (array_key_exists($hash, $this->builders)) {
                $index = $this->builders[ $hash ];
                unset($this->builders[ $hash ]);
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

    /**
     * @return boolen
     */
    public function offsetExists($offset)
    {
        return isset($this->builders[ $offset ]);
    }

    /**
     * @return AbstractPageBuilder
     */
    public function offsetGet($offset)
    {
        return $this->builders[ $offset ];
    }

    /**
     * @throws \RuntimeException if instance other than AbstractPageBuilder provided
     *                           \RuntimeException if non integer index provided
     */
    public function offsetSet($offset, $value)
    {
        if (!$value instanceof AbstractPageBuilder) {
            throw new \RuntimeException('only instance of AbstractPageBuilder allowed for PageBuilderCollection');
        }

        if ($offset === null) {
            end($this->builders);
            $offset = (int) key($this->builders);
        }

        if (!is_int($offset)) {
            throw new \RuntimeException('only integer indices allowed for PageBuilderCollection');
        }

        $this->add($value, $offset);
    }

    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }
}
