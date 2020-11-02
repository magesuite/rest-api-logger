<?php

namespace MageSuite\RestApiLogger\Plugin\Webapi\Controller\Rest;

class RestApiRequestLogger
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

    /**
     * @param \Magento\Webapi\Controller\Rest $subject
     * @param \Magento\Framework\App\RequestInterface|\Magento\Framework\Webapi\Rest\Request $request
     * @return void
     * @throws \Exception
     */
    public function beforeDispatch(
        \Magento\Webapi\Controller\Rest $subject,
        \Magento\Framework\App\RequestInterface $request
    ) {
        if ($this->configHelper->isApiLoggingEnabled() && $this->configHelper->isEndpointValidToLog($request->getPathInfo())) {
            $this->createNewRestLogCommand->execute($request);
        }
    }
}

