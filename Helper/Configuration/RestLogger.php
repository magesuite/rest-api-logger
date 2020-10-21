<?php

namespace MageSuite\RestApiLogger\Helper\Configuration;

class RestLogger
{
    const ENABLED_XML_PATH = 'system/restapi_logger/api_logging_enabled';
    const RESPONSE_ENABLED_XML_PATH = 'system/restapi_logger/api_response_logging_enabled';
    const ENDPOINTS_TO_LOG_XML_PATH = 'system/restapi_logger/rest_endpoints_to_log';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface)
    {
        $this->scopeConfig = $scopeConfigInterface;
    }

    public function isApiLoggingEnabled()
    {
        return $this->scopeConfig->getValue(
            self::ENABLED_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function isApiResponseLoggingEnabled()
    {
        return $this->scopeConfig->getValue(
            self::RESPONSE_ENABLED_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getRestEndpointsToLogPayload()
    {
        $endpoints = $this->scopeConfig->getValue(
            self::ENDPOINTS_TO_LOG_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return preg_split('/\n|\r\n?/', $endpoints);
    }
}
