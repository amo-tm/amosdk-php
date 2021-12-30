<?php

namespace Amo\Sdk\Models;

class AbstractCollectionModel extends AbstractModel
{
    /**
     * @var AbstractModel[]
     */
    protected array $items = [];

    protected string $itemClass = AbstractModel::class;

    protected function setData(array $data)
    {
        if (!is_array($data)) {
            throw new \InvalidArgumentException('data must be array of models');
        }

        foreach ($data as $item) {
            if ($item instanceof $this->itemClass) {
                $this->items[] = $item;
            } else {
                $this->items[] = new $this->itemClass($item);
            }
        }
    }


    protected function toApi(): array
    {
        $data = [];
        foreach ($this->items as $item) {
            $data[] = $item->toApi();
        }
        return array_values($data);
    }

    public function toArray(): array
    {
        return $this->items;
    }
}