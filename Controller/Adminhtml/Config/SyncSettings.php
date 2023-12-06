<?php

namespace Dispatch\SalesChannel\Controller\Adminhtml\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Dispatch\SalesChannel\Helper\Data as DataHelper;
use Magento\Framework\Message\ManagerInterface;

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
     * @var DataHelper
     */
    protected $dataHelper;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * SyncSettings constructor.
     *
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param DataHelper $dataHelper
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        DataHelper $dataHelper,
        ManagerInterface $messageManager
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->dataHelper = $dataHelper;
        $this->messageManager = $messageManager;
    }

    /**
     * Execute the controller action.
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $result  = $this->resultJsonFactory->create();
        $storeId = $this->getRequest()->getParam('store');

        try {
            $response = $this->dataHelper->syncSettingsApi($storeId);
            $data = json_decode($response, true);
            if (isset($data['statusCode']) && $data['statusCode'] === 200) {
                $response = [
                    'success' => true,
                    'message' => __('Sync settings successful.'),
                ];
                $this->messageManager->addSuccess(__("Sync settings successful."));
            } else {
                $response = [
                    'success' => false,
                    'message' => __($data['message']),
                ];
                $this->messageManager->addError(__($data['message']));
            }
        } catch (\Exception $e) {
        }
        return $result->setData($response);
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
