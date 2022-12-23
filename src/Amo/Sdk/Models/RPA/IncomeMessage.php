<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractModel;

class IncomeMessage extends AbstractModel
{
    protected string $id;
    protected array  $author;
    protected string $receiver;
    protected string $text;
    protected string $created_at;
    protected string $updated_at;

     /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getAuthor(): array
    {
        return $this->author;
    }

    /**
     * @return array
     */
    public function getReceiver(): array
    {
        return $this->receiver;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}
