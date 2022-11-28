<?php

namespace MageSuite\RestApiLogger\Model\Command;

class CreateNewRestLog
{
    protected \MageSuite\RestApiLogger\Api\RestLogRepositoryInterface $restLogRepository;

    protected \MageSuite\RestApiLogger\Api\Data\RestLogInterface $restLog;

    protected \MageSuite\RestApiLogger\Helper\RestLog\Replacer $replacer;

    protected \MageSuite\RestApiLogger\Helper\RestLog\Formatter $formatter;

    protected \Magento\Authorization\Model\UserContextInterface $userContext;

    public function __construct(
        \MageSuite\RestApiLogger\Api\RestLogRepositoryInterface $restLogRepository,
        \MageSuite\RestApiLogger\Helper\RestLog\Replacer $replacer,
        \MageSuite\RestApiLogger\Helper\RestLog\Formatter $formatter,
        \Magento\Authorization\Model\UserContextInterface $userContext
    ) {
        $this->restLogRepository = $restLogRepository;
        $this->replacer = $replacer;
        $this->formatter = $formatter;
        $this->userContext = $userContext;
    }

    public function execute($dataObject)
    {
        if ($dataObject instanceof \Magento\Framework\App\RequestInterface) {
            $this->restLog = $this->restLogRepository->create();
            $this->restLog->setEndpoint($dataObject->getPathInfo());
            $payloadContentWithPlaceholders = $this->replacer->applyPayloadPlaceholders($dataObject->getContent());
            $croppedPayloadContent = $this->formatter->cropPayloadContent($payloadContentWithPlaceholders);
            $this->restLog->setPayload($croppedPayloadContent);
            $this->restLog->setHttpMethod($dataObject->getMethod());
            $this->restLog->setIpAddress($dataObject->getClientIp());
        }

        if ($dataObject instanceof \Magento\Framework\Webapi\Rest\Response && $this->restLog) {
            $this->restLog->setResponseCode($dataObject->getStatusCode());
            $responseContentWithPlaceholders = $this->replacer->applyResponsePlaceholders($dataObject->getContent());
            $this->restLog->setResponse($responseContentWithPlaceholders);

            if ($this->userContext->getUserType() == \Magento\Authorization\Model\UserContextInterface::USER_TYPE_INTEGRATION) {
                $this->restLog->setIntegrationId($this->userContext->getUserId());
            }
        }

        $this->restLogRepository->save($this->restLog);
    }
}
