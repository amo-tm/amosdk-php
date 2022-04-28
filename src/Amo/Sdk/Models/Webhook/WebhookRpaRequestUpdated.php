<?php

namespace Amo\Sdk\Models\Webhook;

use Amo\Sdk\Models\AbstractModel;
use Amo\Sdk\Models\RPA\Request;
use Amo\Sdk\Models\RPA\RequestChange;
use Amo\Sdk\Models\RPA\RequestChangesCollection;
use Carbon\Carbon;

class WebhookRpaRequestUpdated extends AbstractModel implements Interfaces\WebhookEvent
{
    protected array $_embedded = [
        'request' => Request::class,
    ];

    protected string $requestId;
    protected \DateTimeInterface $modifiedAt;
    protected RequestChangesCollection $changes;

    protected array $cast = [
        'changes' => RequestChangesCollection::class,
        'modifiedAt' => Carbon::class
    ];

    public function getRequest(): Request {
        return $this->getEmbedded('request');
    }

    /**
     * @return string
     */
    public function getRequestId(): string
    {
        return $this->requestId;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getModifiedAt(): \DateTimeInterface
    {
        return $this->modifiedAt;
    }

    /**
     * @return RequestChangesCollection|RequestChange[]
     */
    public function getChanges(): RequestChangesCollection
    {
        return $this->changes;
    }


}
