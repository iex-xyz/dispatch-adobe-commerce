<?php

namespace Dispatch\SalesChannel\Controller\Adminhtml\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Dispatch\SalesChannel\Helper\Data as DataHelper;
use Magento\Framework\Message\ManagerInterface;

/**
 * TestConnection controller for test connection action.
 */
class TestConnection extends Action
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
     * TestConnection constructor.
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
            $response = $this->dataHelper->testConnectionApi($storeId);
            $data = json_decode($response, true);
            if (isset($data['success']) && $data['success'] === true) {
                $response = [
                    'success' => true,
                    'message' => __('Connection test successful.'),
                ];
                $this->messageManager->addSuccess(__("Connection test successful."));
            } else {
                $response = [
                    'success' => false,
                    'message' => __($data['msg']['0']),
                ];
                $this->messageManager->addError(__($data['msg']['0']));
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
