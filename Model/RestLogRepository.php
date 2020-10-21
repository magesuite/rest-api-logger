<?php

namespace MageSuite\RestApiLogger\Model;

class RestLogRepository implements \MageSuite\RestApiLogger\Api\RestLogRepositoryInterface
{
    /**
     * @var ResourceModel\RestLog
     */
    protected $restLogResource;

    /**
     * @var \MageSuite\RestApiLogger\Api\Data\RestLogInterfaceFactory
     */
    protected $restLogInterfaceFactory;

    /**
     * @var \MageSuite\RestApiLogger\Model\ResourceModel\RestLog\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var \Magento\Framework\Api\SearchResultsInterface
     */
    protected $searchResultFactory;

    public function __construct(
        \MageSuite\RestApiLogger\Model\ResourceModel\RestLog $restLogResource,
        \MageSuite\RestApiLogger\Api\Data\RestLogInterfaceFactory $restLogInterfaceFactory,
        \MageSuite\RestApiLogger\Model\ResourceModel\RestLog\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor,
        \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultFactory
    ) {
        $this->restLogResource = $restLogResource;
        $this->restLogInterfaceFactory = $restLogInterfaceFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultFactory = $searchResultFactory;
    }

    public function create()
    {
        $restLog = $this->restLogInterfaceFactory->create();
        $restLog->setTimestamp(time());

        return $restLog;
    }

    public function getById($id)
    {
        $restLog = $this->restLogInterfaceFactory->create();
        $restLog->load($id);

        if (!$restLog->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Rest Payload Log with id "%1" does not exist.', $id));
        }

        return $restLog;
    }

    public function save(\MageSuite\RestApiLogger\Api\Data\RestLogInterface $restLog)
    {
        return $this->restLogResource->save($restLog);
    }

    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        $collection = $this->collectionFactory->create();

        if (empty($searchCriteria)) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        $searchResult = $this->searchResultFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult
            ->setTotalCount($collection->getSize())
            ->setSearchCriteria($searchCriteria);

        return $searchResult;
    }

    public function delete(\MageSuite\RestApiLogger\Api\Data\RestLogInterface $restLog)
    {
        $this->restLogResource->delete($restLog);
    }
}
