<?php

declare(strict_types=1);

namespace MageSuite\RestApiLogger\Helper\RestLog;

class Formatter
{
    public function __construct(
        protected \MageSuite\RestApiLogger\Helper\Configuration\RestLogger $restLoggerConfiguration
    ) {}

    public function cropPayloadContent(string $logContent): string
    {
        $maximumPayloadLength = $this->restLoggerConfiguration->getMaximumPayloadLength();

        return substr($logContent, 0, $maximumPayloadLength - 1);
    }
}
