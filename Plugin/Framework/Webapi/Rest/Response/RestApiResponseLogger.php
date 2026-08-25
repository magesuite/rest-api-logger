<?php

declare(strict_types=1);

namespace MageSuite\RestApiLogger\Plugin\Framework\Webapi\Rest\Response;

class RestApiResponseLogger
{
    public function __construct(
        protected \MageSuite\RestApiLogger\Helper\Configuration\RestLogger $configHelper,
        protected \MageSuite\RestApiLogger\Model\Command\CreateNewRestLog $createRestLog,
        protected \Magento\Framework\App\RequestInterface $request
    ) {}

    public function afterSendResponse(
        \Magento\Framework\Webapi\Rest\Response $subject,
        $result
    ) {
        if (!$this->configHelper->isApiLoggingEnabled() || !$this->configHelper->isApiResponseLoggingEnabled()) {
            return;
        }

        if (!$this->configHelper->isEndpointValidToLog($this->request->getPathInfo()) || !$this->configHelper->isHttpMethodAllowedToLog($this->request->getMethod())) {
            return;
        }

        $this->createRestLog->execute($subject);
    }
}
