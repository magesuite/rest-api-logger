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

    /**
     * @var \MageSuite\RestApiLogger\Helper\RestLog\Replacer
     */
    protected $replacer;

    /**
     * @var \MageSuite\RestApiLogger\Helper\RestLog\Formatter
     */
    protected $formatter;

    public function __construct(
        \MageSuite\RestApiLogger\Api\RestLogRepositoryInterface $restLogRepository,
        \MageSuite\RestApiLogger\Helper\RestLog\Replacer $replacer,
        \MageSuite\RestApiLogger\Helper\RestLog\Formatter $formatter
    )
    {
        $this->restLogRepository = $restLogRepository;
        $this->replacer = $replacer;
        $this->formatter = $formatter;
    }

    public function execute($dataObject)
    {
        if ($dataObject instanceof \Magento\Framework\App\RequestInterface) {
            $this->restLog = $this->restLogRepository->create();
            $this->restLog->setEndpoint($dataObject->getPathInfo());
            $payloadContentWithPlaceholders = $this->replacer->applyPayloadPlaceholders($dataObject->getContent());
            $croppedPayloadContent = $this->formatter->cropPayloadContent($payloadContentWithPlaceholders);
            $this->restLog->setPayload($croppedPayloadContent);
        }

        if ($dataObject instanceof \Magento\Framework\Webapi\Rest\Response) {
            $this->restLog->setResponseCode($dataObject->getStatusCode());
            $responseContentWithPlaceholders = $this->replacer->applyResponsePlaceholders($dataObject->getContent());
            $this->restLog->setResponse($responseContentWithPlaceholders);
        }

        $this->restLogRepository->save($this->restLog);
    }
}
