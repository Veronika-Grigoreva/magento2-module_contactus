<?php

namespace Test\Form\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Post
 * @package Test\Form\Model
 */
class Post extends AbstractModel
{
    /**
     * constants
     */
    const CACHE_TAG = 'emails';

    /**
     * @var string
     */
    protected $_cacheTag = 'emails';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'emails';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(\Test\Form\Model\ResourceModel\Post::class);
    }
}
