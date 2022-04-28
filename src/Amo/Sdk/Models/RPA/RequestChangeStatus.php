<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractModel;

class RequestChangeStatus extends AbstractModel
{
    protected Status $status;

    protected array $cast = [
        'status' =>  Status::class,
    ];

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }
}
