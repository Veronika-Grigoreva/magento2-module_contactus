<?php

namespace Test\Form\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Contacts
 * @package Test\Form\Block
 */
class Contacts extends Template
{
    /**
     * Contacts constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * @return string
     */
    public function getFormUrl()
    {
        return $this->getUrl('test/form/post');
    }
}
