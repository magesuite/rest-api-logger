<?php

namespace MageSuite\RestApiLogger\Ui\DataProvider;

class RestLogDataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    /**
     * @var \Magento\Ui\DataProvider\SearchResultFactory
     */
    protected $searchResultFactory;

    protected $restLogRepository;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Magento\Framework\Api\Search\ReportingInterface $reporting,
        \Magento\Framework\Api\Search\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Ui\DataProvider\SearchResultFactory $searchResultFactory,
        \MageSuite\RestApiLogger\Api\RestLogRepositoryInterface $restLogRepository,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $reporting, $searchCriteriaBuilder, $request, $filterBuilder, $meta, $data);

        $this->restLogRepository = $restLogRepository;
        $this->searchResultFactory = $searchResultFactory;

    }

    public function getSearchResult()
    {
        $searchCriteria = $this->getSearchCriteria();
        $result = $this->restLogRepository->getList($searchCriteria);

        return $this->searchResultFactory->create(
            $result->getItems(),
            $result->getTotalCount(),
            $searchCriteria,
            'log_id'
        );
    }
}
