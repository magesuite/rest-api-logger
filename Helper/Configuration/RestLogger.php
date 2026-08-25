<?php

declare(strict_types=1);

namespace MageSuite\RestApiLogger\Helper\Configuration;

class RestLogger extends \Magento\Framework\App\Helper\AbstractHelper
{
    public const ENABLED_XML_PATH = 'system/restapi_logger/api_logging_enabled';
    public const MAXIMUM_PAYLOAD_LENGTH_XML_PATH = 'system/restapi_logger/maximum_payload_length';
    public const PAYLOAD_PLACEHOLDERS_XML_PATH = 'system/restapi_logger/payload_placeholders';
    public const RESPONSE_PLACEHOLDERS_XML_PATH = 'system/restapi_logger/response_placeholders';
    public const RESPONSE_ENABLED_XML_PATH = 'system/restapi_logger/api_response_logging_enabled';
    public const HTTP_REQUEST_METHOD_TO_LOG_XML_PATH = 'system/restapi_logger/http_request_methods_to_log';
    public const ENDPOINTS_TO_LOG_XML_PATH = 'system/restapi_logger/rest_endpoints_to_log';
    public const ENDPOINTS_TO_SKIP_XML_PATH = 'system/restapi_logger/rest_endpoints_to_skip';
    public const LOGGING_RETENTION_PERIOD = 'system/restapi_logger/logging_retention_period';
    public const LOG_ONLY_INTEGRATION_REQUEST = 'system/restapi_logger/log_only_integration_request';
    public const LOG_TABLE_OPTIMIZATION_ENABLED_XML_PATH = 'system/restapi_logger/log_table_optimization_enabled';

    public function isApiLoggingEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::ENABLED_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function isApiResponseLoggingEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::RESPONSE_ENABLED_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getMaximumPayloadLength(): int
    {
        return (int) $this->scopeConfig->getValue(
            self::MAXIMUM_PAYLOAD_LENGTH_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getPayloadPlaceholders(): array
    {
        $placeholders = (string)$this->scopeConfig->getValue(
            self::PAYLOAD_PLACEHOLDERS_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $payloadPlaceholders = preg_split('/\n|\r\n?/', $placeholders);
        if ($payloadPlaceholders === false) {
            $payloadPlaceholders = [];
        }

        return $payloadPlaceholders;
    }

    public function getResponsePlaceholders(): array
    {
        $placeholders = (string)$this->scopeConfig->getValue(
            self::RESPONSE_PLACEHOLDERS_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $responsePlaceholders = preg_split('/\n|\r\n?/', $placeholders);
        if ($responsePlaceholders === false) {
            $responsePlaceholders = [];
        }

        return $responsePlaceholders;
    }

    public function getHttpRequestMethodsToLog(): array
    {
        $methods = (string)$this->scopeConfig->getValue(
            self::HTTP_REQUEST_METHOD_TO_LOG_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $allowedToLogMethods = [];
        if ($methods) {
            $allowedToLogMethods = explode(',', $methods);
        }

        return $allowedToLogMethods;
    }

    public function getRestEndpointsToLogPayload(): array
    {
        $endpoints = (string)$this->scopeConfig->getValue(
            self::ENDPOINTS_TO_LOG_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $loggedPayloadEndpoints = preg_split('/\n|\r\n?/', $endpoints);
        if ($loggedPayloadEndpoints === false) {
            $loggedPayloadEndpoints = [];
        }

        return $loggedPayloadEndpoints;
    }

    public function getRestEndpointsToSkipPayload(): array
    {
        $endpoints = (string)$this->scopeConfig->getValue(
            self::ENDPOINTS_TO_SKIP_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $skippedPayloadEndpoints = preg_split('/\n|\r\n?/', $endpoints);
        if ($skippedPayloadEndpoints === false) {
            $skippedPayloadEndpoints = [];
        }

        return $skippedPayloadEndpoints;
    }

    public function getLoggingRetentionPeriod(): int
    {
        return (int) $this->scopeConfig->getValue(
            self::LOGGING_RETENTION_PERIOD,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function isLogTableOptimizationEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::LOG_TABLE_OPTIMIZATION_ENABLED_XML_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function isLogOnlyIntegrationRequest(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::LOG_ONLY_INTEGRATION_REQUEST,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function isEndpointValidToLog(string $pathInfo): bool
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

    public function isHttpMethodAllowedToLog(string $method): bool
    {
        $allowedToLogMethods = $this->getHttpRequestMethodsToLog();

        if (in_array(strtoupper($method), $allowedToLogMethods)) {
            return true;
        }

        return false;
    }
}
