<?php

namespace MageSuite\RestApiLogger\Cron;

class LogsCleanup
{
    /**
     * @var \MageSuite\RestApiLogger\Helper\Configuration\RestLogger
     */
    protected $configuration;

    /**
     * @var \MageSuite\RestApiLogger\Model\ResourceModel\RestLog
     */
    protected $restLogResource;

    public function __construct(
        \MageSuite\RestApiLogger\Helper\Configuration\RestLogger $configuration,
        \MageSuite\RestApiLogger\Model\ResourceModel\RestLog $restLogResource
    ) {
        $this->configuration = $configuration;
        $this->restLogResource = $restLogResource;
    }

    public function execute()
    {
        if (!$this->configuration->isApiLoggingEnabled()) {
            return;
        }

        $daysAgo = $this->configuration->getLoggingRetentionPeriod();

        if ($daysAgo <= 0) {
            return;
        }

        $this->restLogResource->clean($daysAgo);
        if ($this->configuration->isLogTableOptimizationEnabled()) {
            $this->restLogResource->optimize();
        }
    }
}
