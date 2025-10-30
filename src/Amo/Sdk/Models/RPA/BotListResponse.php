<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractModel;

class BotListResponse extends AbstractModel
{
    protected int $count;
    protected ?string $pageToken = null;

    public array $_embedded = [
        'items' => BotListCollection::class
    ];

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    public function getPageToken(): ?string
    {
        return $this->pageToken;
    }

    /**
     * @return BotListCollection|Bot[]
     */
    public function getItems(): BotListCollection
    {
        return $this->getEmbedded('items');
    }
}
