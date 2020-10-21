<?php

namespace MageSuite\RestApiLogger\Cron;

class LogsCleanup
{
    /**
     * @var \MageSuite\RestApiLogger\Helper\Configuration\RestLogger
     */
    protected $configuration;

    /**
     * @var \MageSuite\RestApiLogger\Model\Command\CleanLogs
     */
    protected $cleanLogs;

    public function __construct(
        \MageSuite\RestApiLogger\Helper\Configuration\RestLogger $configuration,
        \MageSuite\RestApiLogger\Model\Command\CleanLogs $cleanLogs
    )
    {
        $this->configuration = $configuration;
        $this->cleanLogs = $cleanLogs;
    }

    public function execute()
    {
        if (!$this->configuration->isApiLoggingEnabled()) {
            return;
        }

        $this->cleanLogs->execute($this->configuration->getLoggingRetentionPeriod());
    }
}
