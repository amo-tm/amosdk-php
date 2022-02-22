<?php

namespace Amo\Sdk\Models;

class AbstractCollectionModel extends AbstractModel implements \Iterator, \ArrayAccess
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