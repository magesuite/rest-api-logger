<?php

declare(strict_types=1);

namespace MageSuite\RestApiLogger\Model\Config\Source;

class Integration implements \Magento\Framework\Data\OptionSourceInterface
{
    protected ?array $options = null;

    public function __construct(
        protected \Magento\Integration\Model\ResourceModel\Integration\CollectionFactory $collectionFactory
    ) {}

    public function toOptionArray(): array
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $collection = $this->collectionFactory->create()
            ->addFieldToSelect(['integration_id', 'name']);
        $this->options = [];

        foreach ($collection as $item) {
            $this->options[] = [
                'value' => $item->getIntegrationId(),
                'label' => $item->getName()
            ];
        }

        return $this->options;
    }
}
