<?php

namespace MageSuite\RestApiLogger\Model\Data;

class RestLog extends \Magento\Framework\Model\AbstractModel implements \MageSuite\RestApiLogger\Api\Data\RestLogInterface
{
    protected function _construct()
    {
        $this->_init(\MageSuite\RestApiLogger\Model\ResourceModel\RestLog::class);
    }

    public function setLogId($logId)
    {
        return $this->setData('log_id', $logId);
    }

    public function getLogId()
    {
        return $this->getData('log_id');
    }

    public function setEndpoint($endpoint)
    {
        return $this->setData('endpoint', $endpoint);
    }

    public function getEndpoint()
    {
        return $this->getData('endpoint');
    }

    public function setPayload($payload)
    {
        return $this->setData('payload', $payload);
    }

    public function getPayload()
    {
        return $this->getData('payload');
    }

    public function setTimestamp($timestamp)
    {
        return $this->setData('timestamp', $timestamp);
    }

    public function getTimestamp()
    {
        return $this->getData('timestamp');
    }

    public function setResponseCode($code)
    {
        return $this->setData('response_code', $code);
    }

    public function getResponseCode()
    {
        return $this->getData('response_code');
    }

    public function setResponse($response)
    {
        return $this->setData('response', $response);
    }

    public function getResponse()
    {
        return $this->getData('response');
    }
}
