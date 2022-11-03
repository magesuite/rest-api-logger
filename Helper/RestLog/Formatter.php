<?php

namespace MageSuite\RestApiLogger\Helper\RestLog;

class Formatter
{
    /**
     * @var \MageSuite\RestApiLogger\Helper\Configuration\RestLogger
     */
    protected $restLoggerConfiguration;

    /**
     * @param \MageSuite\RestApiLogger\Helper\Configuration\RestLogger $restLoggerConfiguration
     */
    public function __construct(
        \MageSuite\RestApiLogger\Helper\Configuration\RestLogger $restLoggerConfiguration
    ) {
        $this->restLoggerConfiguration = $restLoggerConfiguration;
    }

    /**
     * @param string $logContent
     * @return string
     */
    public function cropPayloadContent(string $logContent): string
    {
        $maximumPayloadLength = $this->restLoggerConfiguration->getMaximumPayloadLength();

        return substr($logContent, 0, $maximumPayloadLength - 1);
    }
}
