<?php

declare(strict_types=1);

namespace MageSuite\RestApiLogger\Plugin\Webapi\Controller\Rest;

class RestApiRequestLogger
{
    public function __construct(
        protected \MageSuite\RestApiLogger\Helper\Configuration\RestLogger $configHelper,
        protected \MageSuite\RestApiLogger\Model\Command\CreateNewRestLog $createRestLog
    ) {}

    public function beforeDispatch(
        \Magento\Webapi\Controller\Rest $subject,
        \Magento\Framework\App\RequestInterface $request
    ): array
    {
        if (
            !$this->configHelper->isApiLoggingEnabled()
            || !$this->configHelper->isEndpointValidToLog($request->getPathInfo())
            || !$this->configHelper->isHttpMethodAllowedToLog($request->getMethod())
        ) {
            return [$request];
        }

        if ($this->configHelper->isLogOnlyIntegrationRequest() && !$this->createRestLog->isIntegrationContext()) {
            return [$request];
        }

        $this->createRestLog->execute($request);

        return [$request];
    }
}
