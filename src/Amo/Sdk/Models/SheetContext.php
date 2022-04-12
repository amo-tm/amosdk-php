<?php

namespace Amo\Sdk\Models;

use Amo\Sdk\Models\Webhook\Interfaces\WebhookWidgetEvent;

class SheetContext extends AbstractModel implements WebhookWidgetEvent
{
    /**
     * @return string
     */
    public function getCompanyId(): string
    {
        return $this->companyId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getWidgetId(): string
    {
        return $this->widgetId;
    }

    /**
     * @return array
     */
    public function getInputValues(): array
    {
        return $this->inputValues;
    }
    protected string $companyId;
    protected string $userId;
    protected string $widgetId;
    protected array $inputValues;
}
