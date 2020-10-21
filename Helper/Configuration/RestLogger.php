<?php

namespace MageSuite\RestApiLogger\Helper\Configuration;

class RestLogger
{
    const ENABLED_XML_PATH = 'genuport/restapi_logger/rest_payload_enabled';
    const ENDPOINTS_TO_LOG_XML_PATH = 'genuport/restapi_logger/rest_endpoints_to_log';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface)
    {
        $this->scopeConfig = $scopeConfigInterface;
    }

    public function isEnableApiDebugging()
    {
        return $this->scopeConfig->getValue(
            self::ENABLED_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getRestEndpointsToLogPayload()
    {
        $endpoints = $this->scopeConfig->getValue(
            self::ENDPOINTS_TO_LOG_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return explode(',', $endpoints);
    }
}
