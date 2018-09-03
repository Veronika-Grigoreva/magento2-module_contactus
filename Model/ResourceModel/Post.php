<?php

namespace Test\Form\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

/**
 * Class Post
 * @package Test\Form\Model\ResourceModel
 */
class Post extends AbstractDb
{
    /**
     * Post constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('emails', 'id');
    }
}
