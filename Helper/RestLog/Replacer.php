<?php

declare(strict_types=1);

namespace MageSuite\RestApiLogger\Helper\RestLog;

class Replacer
{
    public function __construct(
        protected \MageSuite\RestApiLogger\Helper\Configuration\RestLogger $restLoggerConfiguration,
        protected \MageSuite\RestApiLogger\Helper\RestLog\Placeholder $placeholder
    ) {
    }

    public function applyPayloadPlaceholders(string $payloadContent): string
    {
        $placeholders = $this->restLoggerConfiguration->getPayloadPlaceholders();

        return $this->applyPlaceholdersToLogContent($payloadContent, $placeholders);
    }

    public function applyResponsePlaceholders(string $responseContent): string
    {
        $placeholders = $this->restLoggerConfiguration->getResponsePlaceholders();

        return $this->applyPlaceholdersToLogContent($responseContent, $placeholders);
    }

    public function applyPlaceholdersToLogContent(string $logContent, array $placeholders): string
    {
        if (empty($logContent)) {
            return $logContent;
        }

        $decodedLogContent = json_decode($logContent, true);

        if (json_last_error() !== 0 || !is_array($decodedLogContent)) {
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
