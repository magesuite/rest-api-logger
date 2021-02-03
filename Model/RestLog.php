<?php

namespace MageSuite\RestApiLogger\Model;

class RestLog extends \Magento\Framework\Model\AbstractModel
    implements \MageSuite\RestApiLogger\Api\Data\RestLogInterface
{
    protected function _construct()
    {
        $this->_init(\MageSuite\RestApiLogger\Model\ResourceModel\RestLog::class);
    }

    public function setLogId($logId)
    {
        return $this->setData(self::LOG_ID, $logId);
    }

    public function getLogId()
    {
        return $this->getData(self::LOG_ID);
    }

    public function setEndpoint($endpoint)
    {
        return $this->setData(self::ENDPOINT, $endpoint);
    }

    public function getEndpoint()
    {
        return $this->getData(self::ENDPOINT);
    }

    public function setPayload($payload)
    {
        return $this->setData(self::PAYLOAD, $payload);
    }

    public function getPayload()
    {
        return $this->getData(self::PAYLOAD);
    }

    public function setTimestamp($timestamp)
    {
        return $this->setData(self::TIMESTAMP, $timestamp);
    }

    public function getTimestamp()
    {
        return $this->getData(self::TIMESTAMP);
    }

    public function setResponseCode($code)
    {
        return $this->setData(self::RESPONSE_CODE, $code);
    }

    public function getResponseCode()
    {
        return $this->getData(self::RESPONSE_CODE);
    }

    public function setResponse($response)
    {
        return $this->setData(self::RESPONSE, $response);
    }

    public function getResponse()
    {
        return $this->getData(self::RESPONSE);
    }
}
