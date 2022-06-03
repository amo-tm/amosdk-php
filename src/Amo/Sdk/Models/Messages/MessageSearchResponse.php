<?php

namespace Amo\Sdk\Models\Messages;

use Amo\Sdk\Models\AbstractModel;

class MessageSearchResponse extends AbstractModel
{
    protected int $count;
    protected string $pageToken;

    protected array $_embedded = [
        'items' => MessageCollection::class
    ];

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return string
     */
    public function getPageToken(): string
    {
        return $this->pageToken;
    }

    public function getItems(): MessageCollection {
        return $this->getEmbedded('items');
    }
}
