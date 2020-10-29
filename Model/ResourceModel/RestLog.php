<?php

namespace MageSuite\RestApiLogger\Model\ResourceModel;

class RestLog extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('rest_api_log', 'log_id');
    }
}
