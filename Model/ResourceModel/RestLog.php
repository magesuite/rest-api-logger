<?php

namespace MageSuite\RestApiLogger\Model\ResourceModel;

class RestLog extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public const REST_API_LOG_TABLE = 'rest_api_log';

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    protected $dateTime;

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\Stdlib\DateTime $dateTime,
        $connectionName = null
    ) {
        $this->date = $date;
        $this->dateTime = $dateTime;
        parent::__construct($context, $connectionName);
    }

    protected function _construct()
    {
        $this->_init(self::REST_API_LOG_TABLE, 'log_id');
    }

    /**
     * @param int $daysAgo
     * @return $this
     */
    public function clean(int $daysAgo)
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

    public function optimize()
    {
        $connection = $this->getConnection();
        $connection->query(sprintf('OPTIMIZE TABLE %s', self::REST_API_LOG_TABLE));
    }
}
