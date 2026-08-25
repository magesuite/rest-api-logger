<?php

declare(strict_types=1);

namespace MageSuite\RestApiLogger\Model;

class RestLogRepository implements \MageSuite\RestApiLogger\Api\RestLogRepositoryInterface
{
    public function __construct(
        protected \MageSuite\RestApiLogger\Model\ResourceModel\RestLog $restLogResource,
        protected \MageSuite\RestApiLogger\Api\Data\RestLogInterfaceFactory $restLogInterfaceFactory,
        protected \MageSuite\RestApiLogger\Model\ResourceModel\RestLog\CollectionFactory $collectionFactory,
        protected \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        protected \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor,
        protected \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultFactory
    ) {}

    public function create(): \MageSuite\RestApiLogger\Api\Data\RestLogInterface
    {
        $restLog = $this->restLogInterfaceFactory->create();
        $restLog->setTimestamp(time());

        return $restLog;
    }

    public function getById(int $id): \MageSuite\RestApiLogger\Api\Data\RestLogInterface
    {
        $restLog = $this->restLogInterfaceFactory->create();
        $restLog->load($id);

        if (!$restLog->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Rest Payload Log with id "%1" does not exist.', $id));
        }

        return $restLog;
    }

    public function save(\MageSuite\RestApiLogger\Api\Data\RestLogInterface $restLog): \MageSuite\RestApiLogger\Api\Data\RestLogInterface
    {
        try {
            $this->restLogResource->save($restLog);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __('Could not save the rest api log: %1', $exception->getMessage()),
                $exception
            );
        }

        return $restLog;
    }

    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria): \Magento\Framework\Api\SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResult = $this->searchResultFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult
            ->setTotalCount($collection->getSize())
            ->setSearchCriteria($searchCriteria);

        return $searchResult;
    }

    public function delete(\MageSuite\RestApiLogger\Api\Data\RestLogInterface $restLog): void
    {
        $this->restLogResource->delete($restLog);
    }
}
