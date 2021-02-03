<?php

namespace MageSuite\RestApiLogger\Api\Data;

interface RestLogInterface
{
    const LOG_ID = 'log_id';
    const ENDPOINT = 'endpoint';
    const PAYLOAD = 'payload';
    const RESPONSE_CODE = 'response_code';
    const RESPONSE = 'response';
    const TIMESTAMP = 'timestamp';

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
}
