<?php

namespace MageSuite\RestApiLogger\Plugin\Webapi;

class RestApiLogger
{
    /**
     * @var \MageSuite\RestApiLogger\Helper\Configuration\RestLogger;
     */
    protected $configHelper;

    /**
     * @var \MageSuite\RestApiLogger\Api\RestLogRepositoryInterface
     */
    protected $restLogRepository;

    protected $restLog;

    protected $cleanup;

    /**
     * Rest constructor.
     * @param \MageSuite\RestApiLogger\Model\RestLogFactory $restPayload
     */
    public function __construct(
        \MageSuite\RestApiLogger\Helper\Configuration\RestLogger $configHelper,
        \MageSuite\RestApiLogger\Api\RestLogRepositoryInterface $restLogRepository,
        \MageSuite\RestApiLogger\Model\Command\CleanLogs $cleanup
    ) {
        $this->configHelper = $configHelper;
        $this->restLogRepository = $restLogRepository;
        $this->cleanup = $cleanup;
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
        if ($this->configHelper->isApiLoggingEnabled()) {
            if (in_array($request->getPathInfo(), $this->configHelper->getRestEndpointsToLogPayload())) {
                $this->restLog = $this->restLogRepository->create();
                $this->restLog->setEndpoint($request->getPathInfo());
                $this->restLog->setPayload($request->getContent());
            }
        }
    }

    public function afterSendResponse(
        \Magento\Framework\Webapi\Rest\Response $subject,
        $result
    ) {
        if ($this->configHelper->isApiLoggingEnabled()) {
            if ($this->configHelper->isApiResponseLoggingEnabled()) {
                $this->restLog->setResponseCode($subject->getStatusCode());
                $this->restLog->setResponse($subject->getContent());
            }

            $this->restLogRepository->save($this->restLog);
        }
    }
}

