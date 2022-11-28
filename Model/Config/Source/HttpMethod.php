<?php
declare(strict_types=1);

namespace MageSuite\RestApiLogger\Model\Config\Source;

class HttpMethod implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            [
                'value' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_GET,
                'label' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_GET
            ],
            [
                'value' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_POST,
                'label' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_POST
            ],
            [
                'value' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_PUT,
                'label' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_PUT
            ],
            [
                'value' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_DELETE,
                'label' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_DELETE
            ]
        ];
    }
}
