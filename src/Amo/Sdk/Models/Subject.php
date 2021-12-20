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
    protected Participants $participants;

//    protected array $subscribers;
//    protected array $threads;
//    protected array $status;


    protected array $cast = [
        'author' => Participant::class,
        'participants' => Participants::class
    ];

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