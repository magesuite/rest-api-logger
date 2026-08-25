<?php

declare(strict_types=1);

namespace MageSuite\RestApiLogger\Api;

interface RestLogRepositoryInterface
{
    public function create(): \MageSuite\RestApiLogger\Api\Data\RestLogInterface;

    public function getById(int $id): \MageSuite\RestApiLogger\Api\Data\RestLogInterface;

    public function save(\MageSuite\RestApiLogger\Api\Data\RestLogInterface $restLog): \MageSuite\RestApiLogger\Api\Data\RestLogInterface;

    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria): \Magento\Framework\Api\SearchResultsInterface;

    public function delete(\MageSuite\RestApiLogger\Api\Data\RestLogInterface $restLog): void;
}
