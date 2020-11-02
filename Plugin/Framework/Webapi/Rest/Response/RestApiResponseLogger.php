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

    public function __construct(
        \MageSuite\RestApiLogger\Helper\Configuration\RestLogger $configHelper,
        \MageSuite\RestApiLogger\Model\Command\CreateNewRestLog $createRestLog
    ) {
        $this->configHelper = $configHelper;
        $this->createNewRestLogCommand = $createRestLog;
    }

    public function afterSendResponse(
        \Magento\Framework\Webapi\Rest\Response $subject,
        $result
    ) {
        if ($this->configHelper->isApiLoggingEnabled() && $this->configHelper->isApiResponseLoggingEnabled() && $this->configHelper->getRestRegistry()) {
            $this->configHelper->removeRestRegistry();
            $this->createNewRestLogCommand->execute($subject);
        }
    }
}

