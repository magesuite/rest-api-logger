<?php

namespace MageSuite\RestApiLogger\Helper\Configuration;

class RestLogger
{
    const ENABLED_XML_PATH = 'system/restapi_logger/api_logging_enabled';
    const RESPONSE_ENABLED_XML_PATH = 'system/restapi_logger/api_response_logging_enabled';
    const ENDPOINTS_TO_LOG_XML_PATH = 'system/restapi_logger/rest_endpoints_to_log';
    const LOGGING_RETENTION_PERIOD = 'system/restapi_logger/logging_retention_period';
    const REGISTER_REST_KEY = 'rest_logger_started';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface,
        \Magento\Framework\Registry $registry
    ) {
        $this->scopeConfig = $scopeConfigInterface;
        $this->registry = $registry;
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

    public function getLoggingRetentionPeriod()
    {
        return $this->scopeConfig->getValue(
            self::LOGGING_RETENTION_PERIOD,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function setRestRegistry()
    {
        $this->registry->register(self::REGISTER_REST_KEY, true);
    }

    public function getRestRegistry()
    {
        $result = false;
        if ($registryValue = $this->registry->registry(self::REGISTER_REST_KEY)) {
            $result = $registryValue;
        }

        return $result;
    }

    public function removeRestRegistry()
    {
        $this->registry->unregister(self::REGISTER_REST_KEY);
    }
}
