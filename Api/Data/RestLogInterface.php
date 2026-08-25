<?php

declare(strict_types=1);

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
    public const INTEGRATION_ID = 'integration_id';

    /**
     * @param int $logId
     * @return self
     */
    public function setLogId(int $logId): self;

    /**
     * @return int
     */
    public function getLogId(): int;

    /**
     * @param string $endpoint
     * @return self
     */
    public function setEndpoint(string $endpoint): self;

    /**
     * @return string
     */
    public function getEndpoint(): string;

    /**
     * @param string $payload
     * @return self
     */
    public function setPayload(string $payload): self;

    /**
     * @return string
     */
    public function getPayload(): string;

    /**
     * @param int $timestamp
     * @return self
     */
    public function setTimestamp(int $timestamp): self;

    /**
     * @return int
     */
    public function getTimestamp(): int;

    /**
     * @param int $code
     * @return self
     */
    public function setResponseCode(int $code): self;

    /**
     * @return int
     */
    public function getResponseCode(): int;

    /**
     * @param string $response
     * @return self
     */
    public function setResponse(string $response): self;

    /**
     * @return string
     */
    public function getResponse(): string;

    /**
     * @param string $method
     * @return self
     */
    public function setHttpMethod(string $method): self;

    /**
     * @return string
     */
    public function getHttpMethod(): string;

    /**
     * @param string $ipAddress
     * @return self
     */
    public function setIpAddress(string $ipAddress): self;

    /**
     * @return string
     */
    public function getIpAddress(): string;

    /**
     * @return int|null
     */
    public function getIntegrationId(): ?int;

    /**
     * @param int $integrationId
     * @return self
     */
    public function setIntegrationId(int $integrationId): self;
}
