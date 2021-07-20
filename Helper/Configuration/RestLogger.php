<?php

namespace MageSuite\RestApiLogger\Helper\Configuration;

class RestLogger extends \Magento\Framework\App\Helper\AbstractHelper
{
    const ENABLED_XML_PATH = 'system/restapi_logger/api_logging_enabled';
    const MAXIMUM_PAYLOAD_LENGTH_XML_PATH = 'system/restapi_logger/maximum_payload_length';
    const PAYLOAD_PLACEHOLDERS_XML_PATH = 'system/restapi_logger/payload_placeholders';
    const RESPONSE_PLACEHOLDERS_XML_PATH = 'system/restapi_logger/response_placeholders';
    const RESPONSE_ENABLED_XML_PATH = 'system/restapi_logger/api_response_logging_enabled';
    const ENDPOINTS_TO_LOG_XML_PATH = 'system/restapi_logger/rest_endpoints_to_log';
    const ENDPOINTS_TO_SKIP_XML_PATH = 'system/restapi_logger/rest_endpoints_to_skip';
    const LOGGING_RETENTION_PERIOD = 'system/restapi_logger/logging_retention_period';

    /**
     * @return bool
     */
    public function isApiLoggingEnabled(): bool
    {
        return $this->scopeConfig->getValue(
            self::ENABLED_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool
     */
    public function isApiResponseLoggingEnabled(): bool
    {
        return $this->scopeConfig->getValue(
            self::RESPONSE_ENABLED_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return int
     */
    public function getMaximumPayloadLength(): int
    {
        return (int) $this->scopeConfig->getValue(
            self::MAXIMUM_PAYLOAD_LENGTH_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return array
     */
    public function getPayloadPlaceholders(): array
    {
        $placeholders = $this->scopeConfig->getValue(
            self::PAYLOAD_PLACEHOLDERS_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $payloadPlaceholders = preg_split('/\n|\r\n?/', $placeholders);
        if ($payloadPlaceholders === false) {
            $payloadPlaceholders = [];
        }

        return $payloadPlaceholders;
    }

    /**
     * @return array
     */
    public function getResponsePlaceholders(): array
    {
        $placeholders = $this->scopeConfig->getValue(
            self::RESPONSE_PLACEHOLDERS_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $responsePlaceholders = preg_split('/\n|\r\n?/', $placeholders);
        if ($responsePlaceholders === false) {
            $responsePlaceholders = [];
        }

        return $responsePlaceholders;
    }

    /**
     * @return array
     */
    public function getRestEndpointsToLogPayload(): array
    {
        $endpoints = $this->scopeConfig->getValue(
            self::ENDPOINTS_TO_LOG_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $loggedPayloadEndpoints = preg_split('/\n|\r\n?/', $endpoints);
        if ($loggedPayloadEndpoints === false) {
            $loggedPayloadEndpoints = [];
        }

        return $loggedPayloadEndpoints;
    }

    /**
     * @return array
     */
    public function getRestEndpointsToSkipPayload(): array
    {
        $endpoints = $this->scopeConfig->getValue(
            self::ENDPOINTS_TO_SKIP_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $skippedPayloadEndpoints = preg_split('/\n|\r\n?/', $endpoints);
        if ($skippedPayloadEndpoints === false) {
            $skippedPayloadEndpoints = [];
        }

        return $skippedPayloadEndpoints;
    }

    /**
     * @return int
     */
    public function getLoggingRetentionPeriod(): int
    {
        return (int) $this->scopeConfig->getValue(
            self::LOGGING_RETENTION_PERIOD,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @param $pathInfo
     * @return bool
     */
    public function isEndpointValidToLog($pathInfo): bool
    {
        $endpointsToSkip = $this->getRestEndpointsToSkipPayload();

        foreach ($endpointsToSkip as $endpoint) {
            if (fnmatch(trim($endpoint), $pathInfo)) {
                return false;
            }
        }

        $endpointsToLog = $this->getRestEndpointsToLogPayload();

        if (empty($endpointsToLog)) {
            return false;
        }

        foreach ($endpointsToLog as $endpoint) {
            if (fnmatch($endpoint, $pathInfo)) {
                return true;
            }
        }

        return false;
    }
}
