<?php

namespace Test\Form\Controller\Form;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Post
 * @package Test\Form\Controller\Form
 */
class Post extends Action
{
    /**
     * constants
     */
    const ADMIN_EMAIL_CONFIG_PATH = 'trans_email/ident_support/email';
    const ADMIN_NAME_CONFIG_PATH  = 'trans_email/ident_support/name';

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Post constructor.
     * @param Context $context
     * @param TransportBuilder $transportBuilder
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        ResultFactory $resultFactory
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->resultFactory = $resultFactory;

        parent::__construct($context);
    }

    /**
     * Get configuration values
     * @return array
     */
    private function getAdminConfigValues()
    {
        $scopeConfig = ScopeInterface::SCOPE_STORE;

        $adminData = [
            'email'  => $this->scopeConfig->getValue(self::ADMIN_EMAIL_CONFIG_PATH, $scopeConfig),
            'name' => $this->scopeConfig->getValue(self::ADMIN_NAME_CONFIG_PATH, $scopeConfig)
        ];

        return $adminData;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $store = $this->storeManager->getStore()->getId();
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl('/test/form/contacts');

            return $resultRedirect;
        }

        try {
            $data      = $this->getRequest()->getParams();
            $name      = $data['name'];
            $email     = $data['email'];
            $subject   = $data['subject'];
            $messages  = $data['message'];
            $adminData = $this->getAdminConfigValues();

            $transport = $this->transportBuilder->setTemplateIdentifier(
                'email_template'
                )->setTemplateOptions([
                    'area'  => 'frontend',
                    'store' => $store
                ])->setTemplateVars([
                    'message' => $messages,
                    'name'    => $name,
                    'subject' => $subject,
                    'email'   => $email
                ])->addTo($adminData['email'], $adminData['name'])->getTransport();

            $transport->sendMessage();
            $this->messageManager->addSuccessMessage('Email has been sent successfully');
        } catch (MailException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl('/test/form/contacts');

        return $resultRedirect;
    }
}
