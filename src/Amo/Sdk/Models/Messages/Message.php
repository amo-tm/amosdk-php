<?php

namespace Amo\Sdk\Models\Messages;

use Amo\Sdk\Models\AbstractModel;
use Amo\Sdk\Models\Participant;
use Amo\Sdk\Models\Traits\IdentityTrait;
use Carbon\Carbon;

class Message extends AbstractModel
{
    use IdentityTrait;

    protected ?Participant $author;
    protected ?Participant $receiver;
    protected string $text;

    protected ?AttachmentCollection $attachments;

    protected Carbon $createdAt;

    protected Carbon $updatedAt;

    protected ReplyMarkup $replyMarkup;

    protected MessageRef $replyTo;

    static public function text(string $text): Message {
        return new Message([
            'text' => $text
        ]);
    }

    public function setAuthor(?Participant $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function setReceiver(?Participant $receiver): self
    {
        $this->receiver = $receiver;
        return $this;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function setAttachments(AttachmentCollection $attachments): self
    {
        $this->attachments = $attachments;
        return $this;
    }

    public function setReplyMarkup(ReplyMarkup $replyMarkup): self
    {
        $this->replyMarkup = $replyMarkup;
        return $this;
    }

    public function setReplyTo(MessageRef $replyTo): self
    {
        $this->replyTo = $replyTo;
        return $this;
    }

    /**
     * @return Participant|null
     */
    public function getAuthor(): ?Participant
    {
        return $this->author;
    }

    /**
     * @return Participant|null
     */
    public function getReceiver(): ?Participant
    {
        return $this->receiver;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return AttachmentInterface[]
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }
    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }

    /**
     * @return ReplyMarkup
     */
    public function getReplyMarkup(): ReplyMarkup
    {
        return $this->replyMarkup;
    }

    /**
     * @return MessageRef
     */
    public function getReplyTo(): MessageRef
    {
        return $this->replyTo;
    }
}
