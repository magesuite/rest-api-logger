<?php

declare(strict_types=1);

namespace MageSuite\RestApiLogger\Model\ResourceModel;

class RestLog extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public const REST_API_LOG_TABLE = 'rest_api_log';

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        protected \Magento\Framework\Stdlib\DateTime\DateTime $date,
        protected \Magento\Framework\Stdlib\DateTime $dateTime,
        ?string $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
    }

    protected function _construct(): void
    {
        $this->_init(self::REST_API_LOG_TABLE, 'log_id');
    }

    public function clean(int $daysAgo): self
    {
        $cleanTime = $this->date->timestamp("-{$daysAgo} days");
        $connection = $this->getConnection();
        $timeLimit = $this->dateTime->formatDate($cleanTime);

        while (true) {
            $select = $connection->select()
                ->from($this->getMainTable(), 'log_id')
                ->where('timestamp < ?', $timeLimit)
                ->limit(100);
            $logIds = $connection->fetchCol($select);

            if (!$logIds) {
                break;
            }

            $condition = ['log_id IN (?)' => $logIds];
            $connection->delete($this->getMainTable(), $condition);
        }

        return $this;
    }

    public function optimize(): self
    {
        $connection = $this->getConnection();
        $connection->query(sprintf('OPTIMIZE TABLE %s', self::REST_API_LOG_TABLE));

        return $this;
    }
}
