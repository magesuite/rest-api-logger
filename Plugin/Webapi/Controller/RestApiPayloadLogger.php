<?php

namespace MageSuite\RestApiLogger\Plugin\Webapi\Controller;

class RestApiPayloadLogger
{
    /**
     * @var \MageSuite\RestApiLogger\Helper\Configuration\RestLogger;
     */
    protected $configHelper;

    /**
     * @var \MageSuite\RestApiLogger\Api\RestLogRepositoryInterface
     */
    protected $restLogRepository;

    /**
     * Rest constructor.
     * @param \MageSuite\RestApiLogger\Model\RestLogFactory $restPayload
     */
    public function __construct(
        \MageSuite\RestApiLogger\Helper\Configuration\RestLogger $configHelper,
        \MageSuite\RestApiLogger\Api\RestLogRepositoryInterface $restLogRepository
    ) {
        $this->configHelper = $configHelper;
        $this->restLogRepository = $restLogRepository;
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
        if ($this->configHelper->isEnableApiDebugging()) {
            if (in_array($request->getPathInfo(), $this->configHelper->getRestEndpointsToLogPayload())) {
                $restPayloadLog = $this->restLogRepository->create();
                $restPayloadLog->setEndpoint($request->getPathInfo());
                $restPayloadLog->setPayload($request->getContent());

                $this->restLogRepository->save($restPayloadLog);
            }
        }
    }
}

