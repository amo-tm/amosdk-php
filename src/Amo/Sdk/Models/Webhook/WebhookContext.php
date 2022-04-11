<?php

namespace Amo\Sdk\Models\Webhook;

use Amo\Sdk\Models\AbstractModel;

class WebhookContext extends AbstractModel
{
    protected string $companyId;

    /**
     * @return string
     */
    public function getCompanyId(): string
    {
        return $this->companyId;
    }
}
