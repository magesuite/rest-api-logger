<?php

namespace MageSuite\RestApiLogger\Helper\RestLog;

class Replacer
{
    /**
     * @var \MageSuite\RestApiLogger\Helper\Configuration\RestLogger
     */
    protected $restLoggerConfiguration;

    /**
     * @var \Magento\Catalog\Model\View\Asset\Placeholder
     */
    protected $placeholder;

    /**
     * @param \MageSuite\RestApiLogger\Helper\Configuration\RestLogger $restLoggerConfiguration
     * @param Placeholder $placeholder
     */
    public function __construct(
        \MageSuite\RestApiLogger\Helper\Configuration\RestLogger $restLoggerConfiguration,
        \MageSuite\RestApiLogger\Helper\RestLog\Placeholder $placeholder
    )
    {
        $this->restLoggerConfiguration = $restLoggerConfiguration;
        $this->placeholder = $placeholder;
    }

    /**
     * @param string $payloadContent
     * @return string
     */
    public function applyPayloadPlaceholders(string $payloadContent): string
    {
        $placeholders = $this->restLoggerConfiguration->getPayloadPlaceholders();

        return $this->applyPlaceholdersToLogContent($payloadContent, $placeholders);
    }

    /**
     * @param string $responseContent
     * @return string
     */
    public function applyResponsePlaceholders(string $responseContent): string
    {
        $placeholders = $this->restLoggerConfiguration->getResponsePlaceholders();

        return $this->applyPlaceholdersToLogContent($responseContent, $placeholders);
    }

    /**
     * @param string $logContent
     * @return string
     */
    public function applyPlaceholdersToLogContent(string $logContent, array $placeholders): string
    {
        $decodedLogContent = json_decode($logContent, true);
        if (empty($logContent) || json_last_error() !== 0) {
            return $logContent;
        }

        foreach ($placeholders as $placeholder) {

            $placeholderFieldName = $this->placeholder->getFieldName($placeholder);
            $placeholderContent = $this->placeholder->getContent($placeholder);

            if ($placeholderFieldName && $placeholderContent) {
                $decodedLogContent = $this->replaceLogFieldsContent($decodedLogContent, $placeholderFieldName, $placeholderContent);
            }
        }

        return json_encode($decodedLogContent);
    }

    /**
     * @param array $logContent
     * @param string $logFieldName
     * @param string $logFieldValuePlaceholder
     * @return array
     */
    public function replaceLogFieldsContent(array $logContent, string $logFieldName, string $logFieldValuePlaceholder): array
    {
        foreach ($logContent as $field => $value) {
            if ($field === $logFieldName) {
                $logContent[$field] = $logFieldValuePlaceholder;
            }

            if (is_array($logContent[$field])) {
                $logContent[$field] = $this->replaceLogFieldsContent($logContent[$field], $logFieldName, $logFieldValuePlaceholder);
            }
        }

        return $logContent;
    }
}
