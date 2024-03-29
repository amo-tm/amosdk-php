<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractModel;
use Amo\Sdk\Models\Currency;
use Amo\Sdk\Models\ParticipantCollection;

class RequestFieldValue extends AbstractModel
{
    protected ?string $string = null;
    /**
     * @var string[]|null
     */
    protected ?array $enumId = null;

    protected array $cast = [
        'currency' => Currency::class,
        'users' =>  ParticipantCollection::class
    ];

    /**
     * @return string|null
     */
    public function getString(): ?string
    {
        return $this->string;
    }

    /**
     * @return string[]|null
     */
    public function getEnumId(): ?array
    {
        return $this->enumId;
    }

    /**
     * @return float|null
     */
    public function getFloat(): ?float
    {
        return $this->float;
    }

    /**
     * @return int|null
     */
    public function getInt(): ?int
    {
        return $this->int;
    }

    /**
     * @return ParticipantCollection|null
     */
    public function getUsers(): ?ParticipantCollection
    {
        return $this->users;
    }

    /**
     * @return int[]|null
     */
    public function getIntRange(): ?array
    {
        return $this->intRange;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    protected ?float $float = null;
    protected ?int $int = null;
    protected ?ParticipantCollection $users = null;
    protected ?Currency $currency = null;
    /**
     * @var int[]|null
     */
    protected ?array $intRange = null;

    /**
     * @return ParticipantCollection|float|int|string|string[]|null
     */
    public function getValue() {
        switch (true) {
            case !is_null($this->string):
                return $this->string;
            case !is_null($this->enumId):
                return $this->enumId;
            case !is_null($this->float):
                return $this->float;
            case !is_null($this->int):
                return $this->int;
            case !is_null($this->users):
                return $this->users;
            case !is_null($this->intRange):
                return $this->intRange;
            default:
                return null;
        }
    }

    public static function string(string $v): RequestFieldValue {
        return new RequestFieldValue([
            'string' => $v
        ]);
    }

    public static function int(int $v): RequestFieldValue {
        return new RequestFieldValue([
            'int' => $v
        ]);
    }

    public static function float(float $v): RequestFieldValue {
        return new RequestFieldValue([
            'float' => $v
        ]);
    }

    public static function currency(Currency $v): RequestFieldValue {
        return new RequestFieldValue([
            'currency' => $v
        ]);
    }

    /**
     * @param string[] $v
     * @return RequestFieldValue
     */
    public static function enumId(array $v): RequestFieldValue {
        return new RequestFieldValue([
            'enumId' => $v
        ]);
    }
}
