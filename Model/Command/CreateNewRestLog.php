<?php

namespace MageSuite\RestApiLogger\Model\Command;

class CreateNewRestLog
{
    /**
     * @var \MageSuite\RestApiLogger\Api\RestLogRepositoryInterface
     */
    protected $restLogRepository;

    /**
     * @var \MageSuite\RestApiLogger\Api\Data\RestLogInterface
     */
    protected $restLog;

    public function __construct(\MageSuite\RestApiLogger\Api\RestLogRepositoryInterface $restLogRepository)
    {
        $this->restLogRepository = $restLogRepository;
    }

    public function execute($dataObject)
    {
        if ($dataObject instanceof \Magento\Framework\App\RequestInterface) {
            $this->restLog = $this->restLogRepository->create();
            $this->restLog->setEndpoint($dataObject->getPathInfo());
            $this->restLog->setPayload($dataObject->getContent());
        }

        if ($dataObject instanceof \Magento\Framework\Webapi\Rest\Response) {
            $this->restLog->setResponseCode($dataObject->getStatusCode());
            $this->restLog->setResponse($dataObject->getContent());
        }

        $this->restLogRepository->save($this->restLog);
    }
}
