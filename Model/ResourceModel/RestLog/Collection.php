<?php

namespace MageSuite\RestApiLogger\Model\ResourceModel\RestLog;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    public const ENDPOINT_REMOVED_PART = '/rest';
    public const GRID_PAYLOAD_MAXIMUM_LENGTH = 100;
    public const GRID_RESPONSE_MAXIMUM_LENGTH = 100;

    protected function _construct()
    {
        $this->_init(\MageSuite\RestApiLogger\Model\RestLog::class, \MageSuite\RestApiLogger\Model\ResourceModel\RestLog::class);
    }

    /**
     * @inheritDoc
     */
    public function _afterLoad()
    {
        foreach ($this->getItems() as $item) {
            $this->buildItem($item);
        }

        return parent::_afterLoad();
    }

    /**
     * @inheritDoc
     */
    protected function _getConditionSql($fieldName, $condition)
    {
        if ($fieldName === '`endpoint`') {
            $conditionSql = parent::_getConditionSql($fieldName, $condition);
            $conditionStatement = sprintf("REPLACE(endpoint, '%s', '')", self::ENDPOINT_REMOVED_PART);
            return str_replace('`endpoint`', $conditionStatement, $conditionSql);
        }

        return parent::_getConditionSql($fieldName, $condition);
    }

    /**
     * @param \Magento\Framework\DataObject $item
     */
    protected function buildItem(\Magento\Framework\DataObject $item)
    {
        $item->setEndpoint($this->getEndpoint($item));
        $item->setPayload($this->getPayload($item));
        $item->setResponse($this->getResponse($item));
    }

    /**
     * @param \Magento\Framework\DataObject $item
     * @return string
     */
    protected function getEndpoint(\Magento\Framework\DataObject $item): string
    {
        $endpoint = $item->getEndpoint();
        $formattedEndpoint = $endpoint;
        if (strpos($endpoint, self::ENDPOINT_REMOVED_PART) === 0) {
            $formattedEndpoint = substr_replace($endpoint, '', 0, strlen(self::ENDPOINT_REMOVED_PART));
        }

        return $formattedEndpoint;
    }

    /**
     * @param \Magento\Framework\DataObject $item
     * @return string
     */
    public function getPayload(\Magento\Framework\DataObject $item): string
    {
        $htmlElementId = $item->getId();
        $payload = $item->getPayload();
        $payloadGridContent = substr($payload, 0, self::GRID_PAYLOAD_MAXIMUM_LENGTH);

        if (strlen($payload) > self::GRID_PAYLOAD_MAXIMUM_LENGTH) {
            $payloadGridContent = sprintf('%s...', $payloadGridContent);
        }

        if (strlen($payload)) {
            $payloadPreviewLink = $this->getPayloadPreviewLink($htmlElementId, $payload);
            $payloadGridContent = sprintf("%s<br /><br />%s", $payloadGridContent, $payloadPreviewLink);
        }

        return $payloadGridContent;
    }

    /**
     * @param \Magento\Framework\DataObject $item
     * @return string
     */
    public function getResponse(\Magento\Framework\DataObject $item): string
    {
        $htmlElementId = $item->getId();
        $response = $item->getResponse();
        $responseGridContent = substr($response, 0, self::GRID_RESPONSE_MAXIMUM_LENGTH);

        if (strlen($response) > self::GRID_RESPONSE_MAXIMUM_LENGTH) {
            $responseGridContent = sprintf('%s...', $responseGridContent);
        }

        if (strlen($response)) {
            $responsePreviewLink = $this->getResponsePreviewLink($htmlElementId, $response);
            $responseGridContent = sprintf("%s<br /><br />%s", $responseGridContent, $responsePreviewLink);
        }

        return $responseGridContent;
    }

    /**
     * @param int $id
     * @param string $title
     * @param string $content
     * @return string
     */
    public function getPayloadPreviewLink(int $logId, string $content): string
    {
        $formattedContent = json_encode(json_decode($content), JSON_PRETTY_PRINT);
        return <<<HTML
                <a onclick="javascript: openLogContent('$logId', 'payload', 'Payload')">Show Payload</a>
                <div id="payload-modal-{$logId}" style="display:none;">
                    <a onclick="javascript: copyJson('$logId', 'payload')">Copy JSON</a>
                    <div>
                        <textarea rows="50" cols="100" class="payload-content-{$logId}">
                            {$formattedContent}
                        </textarea>
                    </div>
                </div>

HTML;
    }

    public function getResponsePreviewLink(int $logId, string $content): string
    {
        $formattedContent = json_encode(json_decode($content), JSON_PRETTY_PRINT);
        return <<<HTML
                <a onclick="javascript: openLogContent('$logId', 'response', 'Response')">Show Response</a>
                <div id="response-modal-{$logId}" style="display:none;">
                    <a onclick="javascript: copyJson('$logId', 'response')">Copy JSON</a>
                    <div>
                        <textarea rows="50" cols="100" class="response-content-{$logId}">
                            {$formattedContent}
                        </textarea>
                    </div>
                </div>

HTML;
    }
}
