<?php

namespace Dispatch\SalesChannel\Model;

use Dispatch\SalesChannel\Api\ConfigurationManagementInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Cache\Frontend\Pool;
use Magento\Framework\Webapi\Rest\Request;

/**
 * ConfigurationManagement model for initialize api.
 */
class ConfigurationManagement implements ConfigurationManagementInterface
{
    // Constants for XML path configurations
    private const XML_PATH_ENABLED = "sales_channel/general/enabled";
    private const XML_PATH_API_KEY = "sales_channel/general/api_key";
    private const XML_PATH_ACCOUNT_ID = "sales_channel/general/account_id";

    /**
     * @var WriterInterface
     */
    protected $configWriter;

    /**
     * @var TypeListInterface
     */
    protected $cacheTypeList;

    /**
     * @var Pool
     */
    protected $cacheFrontendPool;

    /**
     * @var Request
     */
    protected $request;

    /**
     * ConfigurationManagement constructor.
     *
     * @param WriterInterface $configWriter
     * @param TypeListInterface $cacheTypeList
     * @param Pool $cacheFrontendPool
     * @param Request $request
     */
    public function __construct(
        WriterInterface $configWriter,
        TypeListInterface $cacheTypeList,
        Pool $cacheFrontendPool,
        Request $request
    ) {
        $this->configWriter = $configWriter;
        $this->cacheTypeList = $cacheTypeList;
        $this->cacheFrontendPool = $cacheFrontendPool;
        $this->request = $request;
    }

    /**
     * Set configuration data.
     *
     * @param string $path
     * @param mixed $value
     * @return void
     */
    private function setConfigurationData(string $path, $value): void
    {
        $this->configWriter->save(
            $path,
            $value,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            0
        );
    }

    /**
     * Set configuration values based on request data.
     *
     * @return array
     */
    public function setConfiguration(): array
    {
        $body = $this->request->getBodyParams();
        $configData = $body['data'];

        if (
            isset($configData['enabled']) &&
            isset($configData['api_key']) &&
            isset($configData['account_id'])
        ) {
            try {
                $enabled = $configData['enabled'];
                $apiKey = $configData['api_key'];
                $accountId = $configData['account_id'];

                $this->setConfigurationData(self::XML_PATH_ENABLED, $enabled ? 1 : 0);
                $this->setConfigurationData(self::XML_PATH_API_KEY, $apiKey);
                $this->setConfigurationData(self::XML_PATH_ACCOUNT_ID, $accountId);
                $this->flushCache();

                $response = [
                    [
                        "code" => 'success',
                        "message" => 'enabled, api_key, and account_id fields updated successfully!',
                    ],
                ];
            } catch (\Exception $e) {
                $response = [
                    [
                        "code" => 'error',
                        "message" => $e->getMessage(),
                    ],
                ];
            }
        } else {
            $response = [
                [
                    "code" => 'error',
                    "message" => 'One or more required parameters are missing.',
                ],
            ];
        }

        return $response;
    }

    /**
     * Flush various cache types to reflect changes.
     *
     * @return void
     */
    private function flushCache(): void
    {
        $typesToFlush = [
            'config',
            'layout',
            'block_html',
            'collections',
            'reflection',
            'db_ddl',
            'eav',
            'config_integration',
            'config_integration_api',
            'full_page',
            'translate',
            'config_webservice',
        ];

        foreach ($typesToFlush as $type) {
            $this->cacheTypeList->cleanType($type);
        }

        foreach ($this->cacheFrontendPool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }
    }
}