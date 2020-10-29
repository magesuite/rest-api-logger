<?php

namespace MageSuite\RestApiLogger\Model\Command;

class CleanLogs
{
    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $connection;

    public function __construct(\Magento\Framework\App\ResourceConnection $resource)
    {
        $this->connection = $resource->getConnection();
    }

    public function execute($retentionPeriodInDays) {
        $retentionPeriodInDays = (int)$retentionPeriodInDays;

        if($retentionPeriodInDays <= 0) {
            return;
        }

        $logsTable = $this->connection->getTableName('rest_api_log');

        $this->connection->delete(
            $logsTable,
            "timestamp < date_sub(CURDATE(), INTERVAL ".$retentionPeriodInDays." Day)"
        );
    }
}
