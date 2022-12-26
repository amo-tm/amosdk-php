<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractModel;

class IncomeMessage extends AbstractModel
{
    protected string $id;
    protected array  $author;
    protected array  $receiver;
    protected string $text;
    protected string $created_at;
    protected string $updated_at;

    public function __construct(?array $data)
    {
        if (is_array($data))
            $this->setData($data);
    }
    
     /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return (isset($this->id)) ? $this->id : null;
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
