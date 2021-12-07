<?php

namespace Amo\Sdk\Models\Messages;
use Amo\Sdk\Models\AbstractModel;
use Amo\Sdk\Models\Participant;
use Carbon\Carbon;

class Message extends AbstractModel
{
    protected string $id;
    protected ?Participant $author;
    protected ?Participant $receiver;
    protected string $text;

    /**
     * @var AttachmentInterface[]
     */
    protected array $attachments;

    protected Carbon $createdAt;

    protected Carbon $updatedAt;

    protected ReplyMarkup $replyMarkup;

    protected MessageRef $replyTo;

    /**
     * @return Participant|null
     */
    public function getAuthor(): ?Participant
    {
        return $this->author;
    }

    /**
     * @param Participant|null $author
     */
    public function setAuthor(?Participant $author): void
    {
        $this->author = $author;
    }

    /**
     * @return Participant|null
     */
    public function getReceiver(): ?Participant
    {
        return $this->receiver;
    }

    /**
     * @param Participant|null $receiver
     */
    public function setReceiver(?Participant $receiver): void
    {
        $this->receiver = $receiver;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return AttachmentInterface[]
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * @param AttachmentInterface[] $attachments
     */
    public function setAttachments(array $attachments): void
    {
        $this->attachments = $attachments;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    /**
     * @param Carbon $createdAt
     */
    public function setCreatedAt(Carbon $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }

    /**
     * @param Carbon $updatedAt
     */
    public function setUpdatedAt(Carbon $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return ReplyMarkup
     */
    public function getReplyMarkup(): ReplyMarkup
    {
        return $this->replyMarkup;
    }

    /**
     * @param ReplyMarkup $replyMarkup
     */
    public function setReplyMarkup(ReplyMarkup $replyMarkup): void
    {
        $this->replyMarkup = $replyMarkup;
    }

    /**
     * @return MessageRef
     */
    public function getReplyTo(): MessageRef
    {
        return $this->replyTo;
    }

    /**
     * @param MessageRef $replyTo
     */
    public function setReplyTo(MessageRef $replyTo): void
    {
        $this->replyTo = $replyTo;
    }


}