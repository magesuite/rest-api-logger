<?php

namespace MageSuite\RestApiLogger\Helper\Configuration;

class RestLogger extends \Magento\Framework\App\Helper\AbstractHelper
{
    const ENABLED_XML_PATH = 'system/restapi_logger/api_logging_enabled';
    const RESPONSE_ENABLED_XML_PATH = 'system/restapi_logger/api_response_logging_enabled';
    const ENDPOINTS_TO_LOG_XML_PATH = 'system/restapi_logger/rest_endpoints_to_log';
    const LOGGING_RETENTION_PERIOD = 'system/restapi_logger/logging_retention_period';

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

    public function isEndpointValidToLog($pathInfo)
    {
        $endpoints = $this->getRestEndpointsToLogPayload();

        if (empty($endpoints)) {
            return false;
        }

        foreach ($endpoints as $endpoint) {
            if (fnmatch($endpoint, $pathInfo)) {
                return true;
            }
        }

        return false;
    }
}
