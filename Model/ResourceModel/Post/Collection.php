<?php

namespace Test\Form\Model\ResourceModel\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Test\Form\Model\ResourceModel\Post
 */
class Collection extends AbstractCollection
{
    /**
     * @var int
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Test\Form\Model\Post::class, \Test\Form\Model\ResourceModel\Post::class);
    }
}
