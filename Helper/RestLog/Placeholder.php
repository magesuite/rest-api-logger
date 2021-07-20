<?php

namespace MageSuite\RestApiLogger\Helper\RestLog;

class Placeholder
{
    public const PLACEHOLDER_PARTS_SEPARATOR = ':';

    /**
     * @param string $placeholder
     * @return string|null
     */
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

    /**
     * @param string $placeholder
     * @return string|null
     */
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

    /**
     * @param string|null $placeholderPart
     * @return bool
     */
    public function isPlaceholderPartEmpty(?string $placeholderPart): bool
    {
        if (empty($placeholderPart) && $placeholderPart !== '0') {
            return true;
        }

        return false;
    }
}
