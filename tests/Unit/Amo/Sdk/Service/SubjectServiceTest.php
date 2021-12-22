<?php

namespace Unit\Amo\Sdk\Service;

use Amo\Sdk\AmoClient;
use Amo\Sdk\Models\ParticipantCollection;
use Amo\Sdk\Models\Subject;
use Amo\Sdk\Models\Participant;
use Amo\Sdk\Models\SubjectStatusCollection;
use Amo\Sdk\Models\SubjectThread;
use Amo\Sdk\Models\SubjectThreadCollection;
use Amo\Sdk\Models\SubjectStatus;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class SubjectServiceTest extends TestCase
{
    public function testCreate()
    {
        $container = [];
        $history = Middleware::history($container);

        $testTeamID = Uuid::uuid4()->toString();

        $featureSubject = new Subject([
            'id' => Uuid::uuid4()->toString(),
            'title' => 'Subject Title',
            'external_link' => 'https://example.com/',
            'author' => Participant::user('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
            'participants' => new ParticipantCollection([
                Participant::department('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::accessList('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::bot('ebfaf836-f07b-4df5-809c-2bedb4a2f924')
            ]),
            'subscribers' => new ParticipantCollection([
                Participant::user('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::department('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::accessList('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::bot('ebfaf836-f07b-4df5-809c-2bedb4a2f924')
            ]),
            'threads' => new SubjectThreadCollection([
                new SubjectThread([
                    'id' => Uuid::uuid4()->toString(),
                    'title' => 'Subject Thread #1',
                ]),
                new SubjectThread([
                    'id' => Uuid::uuid4()->toString(),
                    'title' => 'Subject Thread #2',
                ]),
            ]),
            'status' => new SubjectStatusCollection([
                SubjectStatus::status('Status', '#F9F6EE'),
                SubjectStatus::status('Title', '#CFE1A7'),
            ])
        ]);

        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json; charset=UTF-8'], (string)$featureSubject),
        ]);


        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        $sdk = new AmoClient([
            'clientId' => 'testClientID',
            'clientSecret' => 'testClientSecret',
            'httpClient' => new Client(['handler' => $handlerStack]),
        ]);

        $createdSubject = $sdk->team($testTeamID)->subject()->create(new Subject([
            'title' => 'Subject Title',
            'external_link' => 'https://example.com/',
            'author' =>  Participant::user('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
            'participants' => new ParticipantCollection([
                Participant::department('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::accessList('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::bot('ebfaf836-f07b-4df5-809c-2bedb4a2f924')
            ]),
            'subscribers' => new ParticipantCollection([
                Participant::user('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::department('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::accessList('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::bot('ebfaf836-f07b-4df5-809c-2bedb4a2f924')
            ]),
            'threads' => new SubjectThreadCollection([
                new SubjectThread([
                    'title' => 'Subject Thread #1',
                    'avatar_url' => 'https://picsum.photos/600'
                ]),
                new SubjectThread([
                    'title' => 'Subject Thread #2',
                    'avatar_url' => 'https://picsum.photos/600'
                ]),
            ]),
            'status' => new SubjectStatusCollection([
                SubjectStatus::status('Status', '#F9F6EE'),
                SubjectStatus::status('Title', '#CFE1A7'),
            ])
        ]));

        self::assertEquals($featureSubject->getId(), $createdSubject->getId());
        self::assertEquals($featureSubject->getTitle(), $createdSubject->getTitle());
        self::assertEquals($featureSubject->getAuthor(), $createdSubject->getAuthor());
        self::assertEquals($featureSubject->getAuthor(), $createdSubject->getAuthor());
        self::assertEquals($featureSubject->getParticipants(), $createdSubject->getParticipants());
        self::assertEquals($featureSubject->getSubscribers(), $createdSubject->getSubscribers());
        self::assertEquals($featureSubject->getThreads(), $createdSubject->getThreads());
        self::assertEquals($featureSubject->getStatus(), $createdSubject->getStatus());

        foreach ($container as $transaction) {
            /** @var Request $request */
            $request = $transaction['request'];
            self::assertEquals(
                'https://api.amo.io/v1.3/teams/' . $testTeamID . '/subjects',
                (string)$request->getUri(),
            );
            self::assertEquals(
                'POST',
                $request->getMethod(),
            );
        }
    }
}
