<?php

namespace Amo\Sdk\Models\RPA;

use Amo\Sdk\Models\AbstractModel;

class Request extends AbstractModel
{
    protected string $id;
    protected string $statusId;
    protected string $title;
    protected string $authorId;
    protected ?string $externalId = null;
    protected ?RequestFieldsValues $fieldValues = null;

    protected array $cast = [
        'fieldValues' => RequestFieldsValues::class
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
     * @return RequestFieldsValues
     */
    public function getFieldValues(): RequestFieldsValues
    {
        return $this->fieldValues;
    }

    public function getFieldValue(string $fieldId): ?RequestFieldValue {
        return $this->fieldValues->getValue($fieldId);
    }

    public function setFieldValue(string $fieldId, ?RequestFieldValue $value): void {
        if (is_null($this->fieldValues)) {
            $this->fieldValues = new RequestFieldsValues([]);
        }
        $this->fieldValues->setValue($fieldId, $value);
    }
}
