<?php

namespace MageSuite\RestApiLogger\Plugin\Framework\Webapi\Rest\Response;

class RestApiResponseLogger
{
    /**
     * @var \MageSuite\RestApiLogger\Helper\Configuration\RestLogger;
     */
    protected $configHelper;

    /**
     * @var \MageSuite\RestApiLogger\Model\Command\CreateNewRestLog
     */
    protected $createNewRestLogCommand;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    public function __construct(
        \MageSuite\RestApiLogger\Helper\Configuration\RestLogger $configHelper,
        \MageSuite\RestApiLogger\Model\Command\CreateNewRestLog $createRestLog,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->configHelper = $configHelper;
        $this->createNewRestLogCommand = $createRestLog;
        $this->request = $request;
    }

    public function afterSendResponse(
        \Magento\Framework\Webapi\Rest\Response $subject,
        $result
    ) {
        if (
            $this->configHelper->isApiLoggingEnabled()
            && $this->configHelper->isApiResponseLoggingEnabled()
            && $this->configHelper->isEndpointValidToLog($this->request->getPathInfo())
        ) {
            $this->createNewRestLogCommand->execute($subject);
        }
    }
}
