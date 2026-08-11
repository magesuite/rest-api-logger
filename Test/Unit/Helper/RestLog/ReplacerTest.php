<?php

declare(strict_types=1);

namespace MageSuite\RestApiLogger\Test\Unit\Helper\RestLog;

class ReplacerTest extends \PHPUnit\Framework\TestCase
{
    protected ?\MageSuite\RestApiLogger\Helper\RestLog\Replacer $replacer;

    protected function setUp(): void
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        $this->replacer = $objectManager->getObject(\MageSuite\RestApiLogger\Helper\RestLog\Replacer::class, [
            'restLoggerConfiguration' => $this->createMock(\MageSuite\RestApiLogger\Helper\Configuration\RestLogger::class),
            'placeholder' => new \MageSuite\RestApiLogger\Helper\RestLog\Placeholder()
        ]);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('scalarLogContentDataProvider')]
    public function testItReturnsScalarJsonLogContentUnchanged(string $logContent): void
    {
        $result = $this->replacer->applyPlaceholdersToLogContent($logContent, ['password:***']);

        $this->assertEquals($logContent, $result);
    }

    public static function scalarLogContentDataProvider(): array
    {
        return [
            'integer' => ['123'],
            'quoted string' => ['"some string"'],
            'boolean' => ['true'],
            'null literal' => ['null']
        ];
    }

    public function testItMasksFieldValueForJsonObjectContent(): void
    {
        $logContent = json_encode(['password' => 'secret', 'login' => 'test']);

        $result = $this->replacer->applyPlaceholdersToLogContent($logContent, ['password:***']);

        $this->assertEquals(['password' => '***', 'login' => 'test'], json_decode($result, true));
    }
}
