<?php

namespace Amo\Sdk\Models\Webhook;

use Amo\Sdk\Models\AbstractModel;
use Carbon\Carbon;

class Webhook extends AbstractModel
{
    const RPA_BOT_CONTROL_TRANSFERRED = "rpa_bot_control_transferred";
    const RPA_REQUEST_UPDATED = "rpa_request_updated";

    /**
     * @return string
     */
    public function getEventId(): string
    {
        return $this->eventId;
    }

    /**
     * @return string
     */
    public function getEventType(): string
    {
        return $this->eventType;
    }

    /**
     * @return Carbon
     */
    public function getEventTime(): Carbon
    {
        return $this->eventTime;
    }

    public function Context(): WebhookContext {
        return $this->getEmbedded('context');
    }

    public function getWebhookEvent(): Interfaces\WebhookEvent {
        return $this->getEmbedded($this->getEventType());
    }

    protected string $eventId;
    protected string $eventType;
    protected Carbon $eventTime;
    protected array $_embedded = [
        'context' => WebhookContext::class,
        'rpaBotControlTransferred' => WebhookRpaBotControlTransferred::class,
        'rpaRequestUpdated' => WebhookRpaRequestUpdated::class
    ];

    protected array $cast = [
        'eventTime' => Carbon::class
    ];
}
