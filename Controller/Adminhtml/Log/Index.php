<?php

declare(strict_types=1);

namespace MageSuite\RestApiLogger\Controller\Adminhtml\Log;

class Index extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'MageSuite_RestApiLogger::rest_api_logger';

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        protected \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
    }

    public function execute(): \Magento\Framework\View\Result\Page
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Rest API Logs')));

        return $resultPage;
    }
}
