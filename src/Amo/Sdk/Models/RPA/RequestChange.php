<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractModel;

class RequestChange extends AbstractModel
{
    protected ?RequestChangeStatus $status = null;
    protected ?RequestChangeArchiveStatus $archiveStatus = null;
    protected ?RequestChangeFieldValues $fieldsValues = null;

    protected array $cast =  [
        'status' => RequestChangeStatus::class,
        'archiveStatus' => RequestChangeArchiveStatus::class,
        'fieldsValues' => RequestChangeFieldValues::class,
    ];

    /**
     * @return RequestChangeStatus|null
     */
    public function getStatus(): ?RequestChangeStatus
    {
        return $this->status;
    }

    /**
     * @return RequestChangeArchiveStatus|null
     */
    public function getArchiveStatus(): ?RequestChangeArchiveStatus
    {
        return $this->archiveStatus;
    }

    /**
     * @return RequestChangeFieldValues|null
     */
    public function getFieldsValues(): ?RequestChangeFieldValues
    {
        return $this->fieldsValues;
    }


}
