<?php

declare(strict_types=1);

namespace MageSuite\RestApiLogger\Model;

class RestLog extends \Magento\Framework\Model\AbstractModel implements \MageSuite\RestApiLogger\Api\Data\RestLogInterface
{
    protected function _construct(): void
    {
        $this->_init(\MageSuite\RestApiLogger\Model\ResourceModel\RestLog::class);
    }

    public function setLogId(int $logId): self
    {
        return $this->setData(self::LOG_ID, $logId);
    }

    public function getLogId(): int
    {
        return (int)$this->getData(self::LOG_ID);
    }

    public function setEndpoint(string $endpoint): self
    {
        return $this->setData(self::ENDPOINT, $endpoint);
    }

    public function getEndpoint(): string
    {
        return (string)$this->getData(self::ENDPOINT);
    }

    public function setPayload(string $payload): self
    {
        return $this->setData(self::PAYLOAD, $payload);
    }

    public function getPayload(): string
    {
        return $this->getData(self::PAYLOAD);
    }

    public function setTimestamp(int $timestamp): self
    {
        return $this->setData(self::TIMESTAMP, $timestamp);
    }

    public function getTimestamp(): int
    {
        return (int)$this->getData(self::TIMESTAMP);
    }

    public function setResponseCode(int $code): self
    {
        return $this->setData(self::RESPONSE_CODE, $code);
    }

    public function getResponseCode(): int
    {
        return (int)$this->getData(self::RESPONSE_CODE);
    }

    public function setResponse(string $response): self
    {
        return $this->setData(self::RESPONSE, $response);
    }

    public function getResponse(): string
    {
        return (string)$this->getData(self::RESPONSE);
    }

    public function setHttpMethod(string $method): self
    {
        return $this->setData(self::HTTP_METHOD, $method);
    }

    public function getHttpMethod(): string
    {
        return (string)$this->getData(self::HTTP_METHOD);
    }

    public function setIpAddress(string $ipAddress): self
    {
        return $this->setData(self::IP_ADDRESS, $ipAddress);
    }

    public function getIpAddress(): string
    {
        return $this->getData(self::IP_ADDRESS);
    }

    public function getIntegrationId(): ?int
    {
        return $this->getData(self::INTEGRATION_ID) ? (int)$this->getData(self::INTEGRATION_ID) : null;
    }

    public function setIntegrationId(int $integrationId): self
    {
        return $this->setData(self::INTEGRATION_ID, $integrationId);
    }
}
