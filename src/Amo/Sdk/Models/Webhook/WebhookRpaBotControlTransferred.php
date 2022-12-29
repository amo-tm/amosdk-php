<?php

namespace Amo\Sdk\Models\Webhook;

use Amo\Sdk\Models\AbstractModel;
use Amo\Sdk\Models\RPA\Request;
use Amo\Sdk\Models\Messages\Message;

class WebhookRpaBotControlTransferred extends AbstractModel implements Interfaces\WebhookWidgetEvent
{
    protected array $_embedded = [
        'request' => Request::class,
        'incomeMessage' => Message::class
    ];

    protected string $widgetId;
    protected string $botId;
    protected ?array $inputValues = null;

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

    public function getRequest(): Request {
        return $this->getEmbedded('request');
    }
    
    public function getIncomeMessage(): ?Message {
        return $this->getEmbedded('incomeMessage');
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
