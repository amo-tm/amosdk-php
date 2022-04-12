<?php

namespace Amo\Sdk\Models\Webhook\Interfaces;

interface WebhookWidgetEvent extends WebhookEvent
{
    public function getWidgetId(): string;
}
