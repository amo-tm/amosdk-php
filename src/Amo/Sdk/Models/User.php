<?php

namespace Amo\Sdk\Models;

use Amo\Sdk\Models\Traits\PrimaryKeyTrait;

class User extends AbstractModel
{
    use PrimaryKeyTrait;

    protected array $cast =[
        'teamProps' => TeamProps::class
    ];

    protected string $name;
    protected ?string $email = null;
    protected ?string $phone = null;
    protected ?TeamProps $teamProps = null;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array|null
     */
    public function getTeamProps(): ?TeamProps
    {
        return $this->teamProps;
    }
}