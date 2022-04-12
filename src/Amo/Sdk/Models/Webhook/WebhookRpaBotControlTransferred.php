<?php

namespace Amo\Sdk\Models\Webhook;

use Amo\Sdk\Models\AbstractModel;
use Amo\Sdk\Models\RPA\Request;

class WebhookRpaBotControlTransferred extends AbstractModel implements Interfaces\WebhookWidgetEvent
{
    protected array $_embedded = [
        'request' => Request::class
    ];

    /**
     * @return string
     */
    public function getWidgetId(): string
    {
        return $this->widgetId;
    }

    /**
     * @return string
     */
    public function getBotId(): string
    {
        return $this->botId;
    }
    protected string $widgetId;
    protected string $botId;
    protected ?array  $inputValues;

    public function getRequest(): Request {
        return $this->getEmbedded('request');
    }

    /**
     * @return array
     */
    public function getInputValues(): ?array
    {
        return $this->inputValues;
    }

    public function getInputValue($key): mixed {
        return ($this->inputValues ?? [])[$key] ?? null;
    }
}
