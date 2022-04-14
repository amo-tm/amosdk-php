<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractModel;
use Amo\Sdk\Models\ParticipantCollection;

class RequestFieldValue extends AbstractModel
{
    protected ?string $string;
    /**
     * @var string[]|null
     */
    protected ?array $enumId;
    protected ?float $float;
    protected ?int $int;
    protected ?ParticipantCollection $users;

    /**
     * @var int[]|null
     */
    protected ?array $int_range;

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
            default:
                return null;
        }
    }

    public static function string(string $v): RequestFieldValue {
        return new RequestFieldValue([
            'string' => $v
        ]);
    }
}
