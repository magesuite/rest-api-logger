<?php

namespace MageSuite\RestApiLogger\Model\Config\Source;

class HttpRequestMethod implements \Magento\Framework\Option\ArrayInterface
{
    public const HTTP_METHOD_PATCH = 'PATCH';
    public const HTTP_METHOD_TRACE = 'TRACE';
    public const HTTP_METHOD_OPTIONS = 'OPTIONS';
    public const HTTP_METHOD_HEAD = 'HEAD';
    public const HTTP_METHOD_CONNECT = 'CONNECT';

    public function toOptionArray()
    {
        $httpRequestMethods = [
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
            ],
            [
                'value' => self::HTTP_METHOD_CONNECT,
                'label' => self::HTTP_METHOD_CONNECT
            ],
            [
                'value' => self::HTTP_METHOD_HEAD,
                'label' => self::HTTP_METHOD_HEAD
            ],
            [
                'value' => self::HTTP_METHOD_OPTIONS,
                'label' => self::HTTP_METHOD_OPTIONS
            ],
            [
                'value' => self::HTTP_METHOD_TRACE,
                'label' => self::HTTP_METHOD_TRACE
            ],
            [
                'value' => self::HTTP_METHOD_PATCH,
                'label' => self::HTTP_METHOD_PATCH
            ]
        ];

        return $httpRequestMethods;
    }
}
