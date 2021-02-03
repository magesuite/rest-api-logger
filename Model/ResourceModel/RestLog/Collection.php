<?php

namespace MageSuite\RestApiLogger\Model\ResourceModel\RestLog;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(\MageSuite\RestApiLogger\Model\RestLog::class,\MageSuite\RestApiLogger\Model\ResourceModel\RestLog::class);
    }
}
