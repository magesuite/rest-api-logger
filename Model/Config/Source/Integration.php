<?php
declare(strict_types=1);

namespace MageSuite\RestApiLogger\Model\Config\Source;

class Integration implements \Magento\Framework\Data\OptionSourceInterface
{
    protected \Magento\Integration\Model\ResourceModel\Integration\Collection $collection;

    public function __construct(\Magento\Integration\Model\ResourceModel\Integration\CollectionFactory $collectionFactory)
    {
        $this->collection = $collectionFactory->create()->load();
    }

    public function toOptionArray(): array
    {
        $options = [];

        foreach ($this->collection as $item) {
            $options[] = [
                'value' => $item->getIntegrationId(),
                'label' => $item->getName()
            ];
        }

        return $options;
    }
}
