<?php

declare(strict_types=1);

namespace MageSuite\RestApiLogger\Helper\RestLog;

class Placeholder
{
    public const PLACEHOLDER_PARTS_SEPARATOR = ':';

    public function getFieldName(string $placeholder): ?string
    {
        $placeholderParts = explode(self::PLACEHOLDER_PARTS_SEPARATOR, $placeholder);

        if (!isset($placeholderParts[0])) {
            return null;
        }

        if ($this->isPlaceholderPartEmpty($placeholderParts[0])) {
            return null;
        }

        return trim($placeholderParts[0]);
    }

    public function getContent(string $placeholder): ?string
    {
        $placeholderParts = explode(self::PLACEHOLDER_PARTS_SEPARATOR, $placeholder);

        if (!isset($placeholderParts[1])) {
            return null;
        }

        if ($this->isPlaceholderPartEmpty($placeholderParts[1])) {
            return null;
        }

        return trim($placeholderParts[1]);
    }

    public function isPlaceholderPartEmpty(?string $placeholderPart): bool
    {
        if (empty($placeholderPart) && $placeholderPart !== '0') {
            return true;
        }

        return false;
    }
}
