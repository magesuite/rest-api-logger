<?php

declare(strict_types=1);

namespace MageSuite\RestApiLogger\Cron;

class LogsCleanup
{
    public function __construct(
        protected \MageSuite\RestApiLogger\Helper\Configuration\RestLogger $configuration,
        protected \MageSuite\RestApiLogger\Model\ResourceModel\RestLog $restLogResource
    ) {}

    public function execute(): void
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
