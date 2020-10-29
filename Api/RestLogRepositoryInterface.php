<?php

namespace MageSuite\RestApiLogger\Api;

interface RestLogRepositoryInterface
{
    /**
     * @return \MageSuite\RestApiLogger\Api\Data\RestLogInterface
     */
    public function create();

    /**
     * @param int $id
     * @return \MageSuite\RestApiLogger\Api\Data\RestLogInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param \MageSuite\RestApiLogger\Api\Data\RestLogInterface $restLog
     * @return \MageSuite\RestApiLogger\Api\Data\RestLogInterface
     */
    public function save(\MageSuite\RestApiLogger\Api\Data\RestLogInterface $restLog);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     * @return \MageSuite\RestApiLogger\Api\Data\RestLogSearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null);

    /**
     * @param \MageSuite\RestApiLogger\Api\Data\RestLogInterface $restLog
     * @return void
     */
    public function delete(\MageSuite\RestApiLogger\Api\Data\RestLogInterface $restLog);
}
