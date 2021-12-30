<?php

namespace Amo\Sdk\Models;

use Carbon\CarbonInterface;
use Psr\Http\Message\StreamInterface;

abstract class AbstractModel
{
    protected array $cast = [];

    protected array $forceHidden = [
        'cast',
        'forceHidden'
    ];

    protected array $hidden = [];

    public function __construct(array $data)
    {
        $this->setData($data);
    }

    protected function toApi(): array
    {
        $resp = [];
        $hiddenProps = array_merge($this->forceHidden, $this->hidden);
        foreach ($this->getProperties() as $key => $value) {
            if (in_array($key, $hiddenProps, true)) {
                continue;
            }
            if ($value instanceof AbstractModel) {
                $resp[$this->toSnake($key)] = $value->toApi();
            } else if (!empty($value)) {
                $resp[$this->toSnake($key)] = $this->valueToApi($value);
            }
        }
        return $resp;
    }

    public function __toString(): string
    {
        return $this->toJson();
    }

    public function toJson(): string
    {
        $data = $this->toApi();
        if ($data) {
            return json_encode($data);
        } else {
            return json_encode($data, JSON_FORCE_OBJECT);
        }
    }

    private function toSnake(string $key): string
    {
        if (! ctype_lower($key)) {
            $key = preg_replace('/\s+/u', '', ucwords($key));
            $key = mb_strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1_', $key));
        }
        return $key;
    }

    private function toCamel(string $key): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $key))));
    }

    /**
     * @param  $value
     * @return mixed
     */
    private function valueToApi($value)
    {
        if ($value instanceof CarbonInterface) {
            return $value->valueOf();
        }
        return $value;
    }

    /**
     * @param  StreamInterface $stream
     * @return static
     */
    public static function fromStream(StreamInterface $stream)
    {
        return new static(json_decode($stream->getContents(), true));
    }

    /**
     * @param  string $camelKey
     * @return bool
     */
    protected function isPropertyExists(string $camelKey): bool
    {
        return property_exists($this, $camelKey);
    }

    protected function setProperty(string $camelKey, $value)
    {
        $this->{$camelKey} = $value;
    }

    /**
     * @return array
     */
    protected function getProperties(): array
    {
        return get_object_vars($this);
    }

    protected function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $camelKey = $this->toCamel($key);
            if ($this->isPropertyExists($camelKey)) {
                $propType = $this->cast[$camelKey] ?? null;
                if ($propType) {
                    if (class_exists($propType)) {
                        if ($value instanceof $propType) {
                            $this->setProperty($camelKey, $value);
                        } else {
                            $this->setProperty($camelKey, new $propType($value));
                        }
                    }
                } else {
                    $this->setProperty($camelKey, $value);
                }
            }
        }
    }
}
