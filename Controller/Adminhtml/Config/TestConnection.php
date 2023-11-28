<?php

namespace Dispatch\SalesChannel\Controller\Adminhtml\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Dispatch\SalesChannel\Helper\Data as DataHelper;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\Request\Http;

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
     * @var Http
     */
    protected $request;

    /**
     * TestConnection constructor.
     *
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param DataHelper $dataHelper
     * @param ManagerInterface $messageManager
     * @param Http $request
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        DataHelper $dataHelper,
        ManagerInterface $messageManager,
        Http $request
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->dataHelper = $dataHelper;
        $this->messageManager = $messageManager;
        $this->request = $request;
    }

    /**
     * Execute the controller action.
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        try {
            $storeId  = $this->request->getParam('store');
            $response = $this->dataHelper->testConnectionApi($storeId);
            $data = json_decode($response, true);
            if (isset($data['statusCode']) && $data['statusCode'] === 200) {
                $response = [
                    'success' => true,
                    'message' => __('Connection test successfully'),
                ];
                $this->messageManager->addSuccess(__("Connection test successfully"));
            } else {
                $response = [
                    'success' => false,
                    'message' => __($data['msg']['0']),
                ];
                $this->messageManager->addError(__($data['msg']['0']));
            }
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
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
