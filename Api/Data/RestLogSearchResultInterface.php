<?php

namespace MageSuite\RestApiLogger\Api\Data;

interface RestLogSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \MageSuite\RestApiLogger\Api\Data\RestLogInterface[]
     */
    public function getItems();

    /**
     * @param \MageSuite\RestApiLogger\Api\Data\RestLogInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
