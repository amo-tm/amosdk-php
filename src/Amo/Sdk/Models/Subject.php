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
    protected ?UserCollection $participants = null;
    protected ?UserCollection $subscribers = null;
    protected SubjectStatusCollection $status;


    protected array $cast = [
        'author' => Participant::class,
        'participants' => UserCollection::class,
        'subscribers' => UserCollection::class,
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
