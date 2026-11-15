<?php

declare(strict_types=1);

namespace MageSuite\RestApiLogger\Test\Unit\Model\Command;

class CreateNewRestLogTest extends \PHPUnit\Framework\TestCase
{
    protected const MAXIMUM_LENGTH = 100;

    protected \MageSuite\RestApiLogger\Api\Data\RestLogInterface $restLog;
    protected \MageSuite\RestApiLogger\Model\Command\CreateNewRestLog $command;

    protected function setUp(): void
    {
        $this->restLog = $this->createMock(\MageSuite\RestApiLogger\Api\Data\RestLogInterface::class);

        $restLogRepository = $this->createMock(\MageSuite\RestApiLogger\Api\RestLogRepositoryInterface::class);
        $restLogRepository->method('create')->willReturn($this->restLog);

        $configuration = $this->createMock(\MageSuite\RestApiLogger\Helper\Configuration\RestLogger::class);
        $configuration->method('getMaximumPayloadLength')->willReturn(self::MAXIMUM_LENGTH);

        $replacer = $this->createMock(\MageSuite\RestApiLogger\Helper\RestLog\Replacer::class);
        $replacer->method('applyPayloadPlaceholders')->willReturnArgument(0);
        $replacer->method('applyResponsePlaceholders')->willReturnArgument(0);

        $this->command = new \MageSuite\RestApiLogger\Model\Command\CreateNewRestLog(
            $restLogRepository,
            $replacer,
            new \MageSuite\RestApiLogger\Helper\RestLog\Formatter($configuration),
            $this->createMock(\Magento\Authorization\Model\UserContextInterface::class)
        );
    }

    public function testItCropsLongResponseToMaximumLength(): void
    {
        $this->command->execute($this->createRequest());

        $this->restLog->expects($this->once())
            ->method('setResponse')
            ->with(str_repeat('a', self::MAXIMUM_LENGTH - 1));

        $this->command->execute($this->createResponse(str_repeat('a', self::MAXIMUM_LENGTH * 10)));
    }

    public function testItKeepsShortResponseUnchanged(): void
    {
        $this->command->execute($this->createRequest());

        $this->restLog->expects($this->once())
            ->method('setResponse')
            ->with('{"ok":true}');

        $this->command->execute($this->createResponse('{"ok":true}'));
    }

    protected function createRequest(): \Magento\Framework\App\RequestInterface
    {
        $request = $this->createMock(\Magento\Framework\Webapi\Rest\Request::class);
        $request->method('getPathInfo')->willReturn('/V1/products');
        $request->method('getMethod')->willReturn('POST');
        $request->method('getClientIp')->willReturn('127.0.0.1');
        $request->method('getContent')->willReturn('{}');

        return $request;
    }

    protected function createResponse(string $content): \Magento\Framework\Webapi\Rest\Response
    {
        $response = $this->createMock(\Magento\Framework\Webapi\Rest\Response::class);
        $response->method('getContent')->willReturn($content);
        $response->method('getStatusCode')->willReturn(200);

        return $response;
    }
}
