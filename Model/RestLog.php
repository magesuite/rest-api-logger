<?php

namespace MageSuite\RestApiLogger\Model;

class RestLog extends \Magento\Framework\Model\AbstractModel implements \MageSuite\RestApiLogger\Api\Data\RestLogInterface
{
    protected function _construct()
    {
        $this->_init(\MageSuite\RestApiLogger\Model\ResourceModel\RestLog::class);
    }

    /**
     * @inheritDoc
     */
    public function setLogId($logId)
    {
        return $this->setData(self::LOG_ID, $logId);
    }

    /**
     * @inheritDoc
     */
    public function getLogId()
    {
        return $this->getData(self::LOG_ID);
    }

    /**
     * @inheritDoc
     */
    public function setEndpoint($endpoint)
    {
        return $this->setData(self::ENDPOINT, $endpoint);
    }

    /**
     * @inheritDoc
     */
    public function getEndpoint()
    {
        return $this->getData(self::ENDPOINT);
    }

    /**
     * @inheritDoc
     */
    public function setPayload($payload)
    {
        return $this->setData(self::PAYLOAD, $payload);
    }

    /**
     * @inheritDoc
     */
    public function getPayload()
    {
        return $this->getData(self::PAYLOAD);
    }

    /**
     * @inheritDoc
     */
    public function setTimestamp($timestamp)
    {
        return $this->setData(self::TIMESTAMP, $timestamp);
    }

    /**
     * @inheritDoc
     */
    public function getTimestamp()
    {
        return $this->getData(self::TIMESTAMP);
    }

    /**
     * @inheritDoc
     */
    public function setResponseCode($code)
    {
        return $this->setData(self::RESPONSE_CODE, $code);
    }

    /**
     * @inheritDoc
     */
    public function getResponseCode()
    {
        return $this->getData(self::RESPONSE_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setResponse($response)
    {
        return $this->setData(self::RESPONSE, $response);
    }

    /**
     * @inheritDoc
     */
    public function getResponse()
    {
        return $this->getData(self::RESPONSE);
    }

    /**
     * @inheritDoc
     */
    public function setHttpMethod(string $method)
    {
        return $this->setData(self::HTTP_METHOD, $method);
    }

    /**
     * @inheritDoc
     */
    public function getHttpMethod(): ?string
    {
        return $this->getData(self::HTTP_METHOD);
    }

    /**
     * @inheritDoc
     */
    public function setIpAddress(string $ipAddress)
    {
        return $this->setData(self::IP_ADDRESS, $ipAddress);
    }

    /**
     * @inheritDoc
     */
    public function getIpAddress(): ?string
    {
        return $this->getData(self::IP_ADDRESS);
    }
}
