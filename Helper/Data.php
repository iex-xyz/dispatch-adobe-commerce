<?php

namespace Dispatch\SalesChannel\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Store\Model\StoreManagerInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    private const XML_PATH_API_KEY    = "sales_channel/general/api_key";
    private const XML_PATH_ACCOUNT_ID = "sales_channel/general/account_id";
    private const API_URL             = "https://oms-gateway.dispatch.co/api/adobe/commerce/test-connection";

    /**
     * @var Curl $curl
     */
    protected $_curl;

    /**
     * @var StoreManagerInterface $storeManager
     */
    protected $storeManager;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param Curl $curl
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        Curl $curl,
        StoreManagerInterface $storeManager
    ) {
        $this->_curl = $curl;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Get configuration value.
     *
     * @param string $path
     * @return mixed
     */
    private function getConfig(string $path): mixed
    {
        return $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        );
    }

    /**
     * Test the API connection.
     *
     * @return string Response from the API
     */
    public function testConnectionApi()
    {
        $dispatchApiSecret = $this->getConfig(self::XML_PATH_API_KEY);
        $accountId         = $this->getConfig(self::XML_PATH_ACCOUNT_ID);
        $apiUrl            = self::API_URL;
        $storeUrl          = $this->storeManager->getStore()->getBaseUrl();

        $params = [
            "dispatchApiSecret" => $dispatchApiSecret,
            "dispatchAccountID" => $accountId,
            "settingsUrl"       => $storeUrl . "rest/V1/dispatch-salesChannel/sync-settings"
        ];
        $this->_curl->setOption(CURLOPT_CUSTOMREQUEST, 'POST');
        $this->_curl->addHeader('Content-Type', 'application/json');
        $this->_curl->post($apiUrl, json_encode($params));

        $response = $this->_curl->getBody();

        return $response;
    }
}
