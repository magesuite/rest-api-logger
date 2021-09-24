<?php

namespace MageSuite\RestApiLogger\Model\HttpRequestMethod;

class Type implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \MageSuite\RestApiLogger\Model\Config\Source\HttpRequestMethod
     */
    protected $httpRequestMethodSource;

    /**
     * @param \MageSuite\RestApiLogger\Model\Config\Source\HttpRequestMethod $httpRequestMethodSource
     */
    public function __construct(
        \MageSuite\RestApiLogger\Model\Config\Source\HttpRequestMethod $httpRequestMethodSource
    )
    {
        $this->httpRequestMethodSource = $httpRequestMethodSource;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return $this->httpRequestMethodSource->toOptionArray();
    }
}
