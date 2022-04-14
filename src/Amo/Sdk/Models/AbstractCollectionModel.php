<?php

namespace Amo\Sdk\Models;

class AbstractCollectionModel extends AbstractModel implements \Iterator, \ArrayAccess
{
    const COLLECTION_TYPE_ARRAY = 1;
    const COLLECTION_TYPE_MAP = 2;
    /**
     * @var AbstractModel[]
     */
    protected array $items = [];

    protected string $itemClass = AbstractModel::class;

    protected int $collectionType = self::COLLECTION_TYPE_ARRAY;

    protected function setData(array $data)
    {
        if (!is_array($data)) {
            throw new \InvalidArgumentException('data must be array of models');
        }

        foreach ($data as $key => $item) {
            if ($item instanceof $this->itemClass) {
                $itemValue = $item;
            } else {
                $itemValue = new $this->itemClass($item);
            }

            if ($this->collectionType === self::COLLECTION_TYPE_ARRAY) {
                $this->items[] = $itemValue;
            } else if ($this->collectionType === self::COLLECTION_TYPE_MAP) {
                $this->items[$key] = $itemValue;
            }
        }
    }


    protected function toApi(): array
    {
        $data = [];
        foreach ($this->items as $key => $item) {
            $data[$key] = $item->toApi();
        }
        return $data;
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function current()
    {
        return current($this->items);
    }

    public function next()
    {
        return next($this->items);
    }

    public function key()
    {
        return key($this->items);
    }

    public function valid()
    {
        return key($this->items) !== null;
    }

    public function rewind()
    {
        return reset($this->items);
    }

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset] ?? null;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }
}
