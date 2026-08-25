<?php

declare(strict_types=1);

namespace MageSuite\RestApiLogger\Model\Command;

class CreateNewRestLog
{
    protected ?\MageSuite\RestApiLogger\Api\Data\RestLogInterface $restLog = null;

    public function __construct(
        protected \MageSuite\RestApiLogger\Api\RestLogRepositoryInterface $restLogRepository,
        protected \MageSuite\RestApiLogger\Helper\RestLog\Replacer $replacer,
        protected \MageSuite\RestApiLogger\Helper\RestLog\Formatter $formatter,
        protected \Magento\Authorization\Model\UserContextInterface $userContext
    ) {}

    public function execute(mixed $dataObject): void
    {
        if ($dataObject instanceof \Magento\Framework\App\RequestInterface) {
            $this->restLog = $this->restLogRepository->create();
            $this->restLog->setEndpoint($dataObject->getPathInfo());
            $this->restLog->setHttpMethod($dataObject->getMethod());
            $this->restLog->setIpAddress($dataObject->getClientIp());
            $payloadContentWithPlaceholders = $this->replacer->applyPayloadPlaceholders($dataObject->getContent());
            $croppedPayloadContent = $this->formatter->cropPayloadContent($payloadContentWithPlaceholders);
            $this->restLog->setPayload($croppedPayloadContent);
        }

        if ($dataObject instanceof \Magento\Framework\Webapi\Rest\Response && $this->restLog) {
            $this->restLog->setResponseCode($dataObject->getStatusCode());
            $responseContentWithPlaceholders = $this->replacer->applyResponsePlaceholders($dataObject->getContent());
            $this->restLog->setResponse($responseContentWithPlaceholders);

            if ($this->isIntegrationContext()) {
                $this->restLog->setIntegrationId($this->userContext->getUserId());
            }
        }

        if ($this->restLog === null) {
            return;
        }

        $this->restLogRepository->save($this->restLog);
    }

    public function isIntegrationContext(): bool
    {
        return $this->userContext->getUserType() == \Magento\Authorization\Model\UserContextInterface::USER_TYPE_INTEGRATION;
    }
}
