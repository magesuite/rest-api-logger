<?php

namespace MageSuite\RestApiLogger\Api\Data;

interface RestLogInterface
{
    public const LOG_ID = 'log_id';
    public const ENDPOINT = 'endpoint';
    public const PAYLOAD = 'payload';
    public const RESPONSE_CODE = 'response_code';
    public const RESPONSE = 'response';
    public const TIMESTAMP = 'timestamp';
    public const HTTP_METHOD = 'http_method';
    public const IP_ADDRESS = 'ip_address';

    /**
     * @param $logId
     * @return $this
     */
    public function setLogId($logId);

    /**
     * @return int|null
     */
    public function getLogId();

    /**
     * @param string $endpoint
     * @return $this
     */
    public function setEndpoint($endpoint);

    /**
     * @return string|null
     */
    public function getEndpoint();

    /**
     * @param string $payload
     * @return string
     */
    public function setPayload($payload);

    /**
     * @return string|null
     */
    public function getPayload();

    /**
     * @param string $timestamp
     * @return string|null
     */
    public function setTimestamp($timestamp);

    /**
     * @return string|null
     */
    public function getTimestamp();

    /**
     * @param int $code
     * @return int
     */
    public function setResponseCode($code);

    /**
     * @return int|null
     */
    public function getResponseCode();

    /**
     * @param string $response
     * @return string
     */
    public function setResponse($response);

    /**
     * @return string|null
     */
    public function getResponse();

    /**
     * @param string $method
     * @return string
     */
    public function setHttpMethod(string $method);

    /**
     * @return string|null
     */
    public function getHttpMethod(): ?string;

    /**
     * @param string $ipAddress
     * @return string
     */
    public function setIpAddress(string $ipAddress);

    /**
     * @return string|null
     */
    public function getIpAddress(): ?string;
}
