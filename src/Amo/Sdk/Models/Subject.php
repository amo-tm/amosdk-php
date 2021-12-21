<?php

namespace Amo\Sdk\Models;

use Amo\Sdk\Models\Traits\PrimaryKeyTrait;
use Amo\Sdk\Service\TeamService;
use Psr\Http\Message\StreamInterface;

class Subject extends AbstractModel
{
    use PrimaryKeyTrait;

    protected string $title;
    protected string $externalLink;
    protected Participant $author;
    protected ParticipantCollection $participants;
    protected ParticipantCollection $subscribers;
    protected SubjectThreadCollection $threads;
    protected SubjectStatusCollection $status;


    protected array $cast = [
        'author' => Participant::class,
        'participants' => ParticipantCollection::class,
        'subscribers' => ParticipantCollection::class,
        'threads' => SubjectThreadCollection::class,
        'status' => SubjectStatusCollection::class,
    ];

    /**
     * @return array
     */
    public function getStatus(): array
    {
        return $this->status->toArray();
    }

    /**
     * @return array
     */
    public function getThreads(): array
    {
        return $this->threads->toArray();
    }

    /**
     * @return array
     */
    public function getSubscribers(): array
    {
        return $this->subscribers->toArray();
    }

    /**
     * @return array
     */
    public function getParticipants(): array
    {
        return $this->participants->toArray();
    }

    /**
     * @return Participant
     */
    public function getAuthor(): Participant
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getExternalLink(): string
    {
        return $this->externalLink;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}