<?php

namespace Dispatch\SalesChannel\Controller\Adminhtml\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * SyncSettings controller for Sync Settings action.
 */
class SyncSettings extends Action
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * SyncSettings constructor.
     *
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Execute the controller action.
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $result = ['message' => 'Sync Settings.'];

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($result);
    }

    /**
     * Check permission via ACL resource.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dispatch_SalesChannel::config');
    }
}
