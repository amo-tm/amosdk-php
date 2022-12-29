<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractModel;
use Amo\Sdk\Models\Participant;

class Request extends AbstractModel
{
    protected string $id;
    protected string $statusId;
    protected string $title;
    protected string $seqId;
    protected string $authorId;
    protected string $responsibleId;
    protected ?Participant $responsible;
    protected ?string $externalId = null;
    protected ?RequestFieldsValuesCollection $fieldValues = null;

    protected array $cast = [
        'fieldValues' => RequestFieldsValuesCollection::class,
        'responsible' => Participant::class
    ];

    protected array $_embedded = [
        'fields' => FieldsListCollection::class,
        'statuses' => StatusesListCollection::class,
    ];

    public static function withId(string $id): Request {
        return new Request(['id' => $id]);
    }

    /**
     * @return string|null
     */
    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    /**
     * @return string|null
     */
    public function getSeqId(): ?string
    {
        return $this->seqId;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatusId(): string
    {
        return $this->statusId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    /**
     * @return RequestFieldsValuesCollection
     */
    public function getFieldValues(): RequestFieldsValuesCollection
    {
        return $this->fieldValues;
    }

    public function getFieldValue(string $fieldId): ?RequestFieldValue {
        return $this->fieldValues->getValue($fieldId);
    }

    public function setFieldValue(string $fieldId, ?RequestFieldValue $value): void {
        if (is_null($this->fieldValues)) {
            $this->fieldValues = new RequestFieldsValuesCollection([]);
        }
        $this->fieldValues->setValue($fieldId, $value);
    }

    /**
     * @return string
     */
    public function getResponsibleId(): string
    {
        return $this->responsibleId;
    }
    
    /**
     * @return null|Participant
     */
    public function getResponsible(): ?Participant
    {
        return $this->responsible;
    }
}
