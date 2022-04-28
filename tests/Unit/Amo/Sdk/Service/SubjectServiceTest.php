<?php

namespace Unit\Amo\Sdk\Service;

use Amo\Sdk\AmoClient;
use Amo\Sdk\Models\UserCollection;
use Amo\Sdk\Models\Subject;
use Amo\Sdk\Models\Participant;
use Amo\Sdk\Models\SubjectParticipantsResponse;
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
use phpDocumentor\Reflection\Types\Array_;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class SubjectServiceTest extends TestCase
{

    public function testSubscribersRemove()
    {
        $container = [];
        $history = Middleware::history($container);

        $testTeamID = Uuid::uuid4()->toString();
        $testSubjectID = Uuid::uuid4()->toString();

        $featureSubscribersRemoveResponse = new SubjectParticipantsResponse([
            'count' => 5,
            'affected' => 4,
        ]);

        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json; charset=UTF-8'], (string)$featureSubscribersRemoveResponse),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        $sdk = new AmoClient([
            'clientId' => 'testClientID',
            'clientSecret' => 'testClientSecret',
            'httpClient' => new Client(['handler' => $handlerStack]),
        ]);

        $subscribersRemoveResponse = $sdk->team($testTeamID)->subject($testSubjectID)->subscribersRemove(new UserCollection([
            Participant::department('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
            Participant::accessList('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
            Participant::bot('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
            Participant::user('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
        ]));

        self::assertEquals($featureSubscribersRemoveResponse->getCount(), $subscribersRemoveResponse->getCount());
        self::assertEquals($featureSubscribersRemoveResponse->getAffected(), $subscribersRemoveResponse->getAffected());

        foreach ($container as $transaction) {
            /** @var Request $request */
            $request = $transaction['request'];
            self::assertEquals(
                'https://api.amo.io/v1.3/subjects/' . $testSubjectID . '/subscribers',
                (string)$request->getUri(),
            );
            self::assertEquals(
                'DELETE',
                $request->getMethod(),
            );
        }
    }
    public function testSubscribersAdd()
    {
        $container = [];
        $history = Middleware::history($container);

        $testTeamID = Uuid::uuid4()->toString();
        $testSubjectID = Uuid::uuid4()->toString();

        $featureSubscribersAddResponse = new SubjectParticipantsResponse([
            'count' => 5,
            'affected' => 4,
        ]);

        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json; charset=UTF-8'], (string)$featureSubscribersAddResponse),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        $sdk = new AmoClient([
            'clientId' => 'testClientID',
            'clientSecret' => 'testClientSecret',
            'httpClient' => new Client(['handler' => $handlerStack]),
        ]);

        $subscribersAddedResponse = $sdk->team($testTeamID)->subject($testSubjectID)->subscribersAdd(new UserCollection(
            [
                Participant::user('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::department('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::accessList('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::bot('ebfaf836-f07b-4df5-809c-2bedb4a2f924')
            ]
        ));

        self::assertEquals($featureSubscribersAddResponse->getCount(), $subscribersAddedResponse->getCount());
        self::assertEquals($featureSubscribersAddResponse->getAffected(), $subscribersAddedResponse->getAffected());

        foreach ($container as $transaction) {
            /** @var Request $request */
            $request = $transaction['request'];
            self::assertEquals(
                'https://api.amo.io/v1.3/subjects/'. $testSubjectID . '/subscribers',
                (string)$request->getUri(),
            );
            self::assertEquals(
                'PUT',
                $request->getMethod(),
            );
        }
    }


    public function testParticipantsRemove()
    {
        $container = [];
        $history = Middleware::history($container);

        $testTeamID = Uuid::uuid4()->toString();
        $testSubjectID = Uuid::uuid4()->toString();

        $featureParticipantsRemoveResponse = new SubjectParticipantsResponse([
            'count' => 5,
            'affected' => 4,
        ]);

        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json; charset=UTF-8'], (string)$featureParticipantsRemoveResponse),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        $sdk = new AmoClient([
            'clientId' => 'testClientID',
            'clientSecret' => 'testClientSecret',
            'httpClient' => new Client(['handler' => $handlerStack]),
        ]);

        $participantsRemoveResponse = $sdk->team($testTeamID)->subject($testSubjectID)->participantsRemove(new UserCollection([
            Participant::department('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
            Participant::accessList('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
            Participant::bot('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
            Participant::user('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
        ]));

        self::assertEquals($featureParticipantsRemoveResponse->getCount(), $participantsRemoveResponse->getCount());
        self::assertEquals($featureParticipantsRemoveResponse->getAffected(), $participantsRemoveResponse->getAffected());

        foreach ($container as $transaction) {
            /** @var Request $request */
            $request = $transaction['request'];
            self::assertEquals(
                'https://api.amo.io/v1.3/subjects/' . $testSubjectID . '/participants',
                (string)$request->getUri(),
            );
            self::assertEquals(
                'DELETE',
                $request->getMethod(),
            );
        }
    }
    public function testParticipantsAdd()
    {
        $container = [];
        $history = Middleware::history($container);

        $testTeamID = Uuid::uuid4()->toString();
        $testSubjectID = Uuid::uuid4()->toString();

        $featureParticipantsAddResponse = new SubjectParticipantsResponse([
            'count' => 5,
            'affected' => 4,
        ]);

        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json; charset=UTF-8'], (string)$featureParticipantsAddResponse),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        $sdk = new AmoClient([
            'clientId' => 'testClientID',
            'clientSecret' => 'testClientSecret',
            'httpClient' => new Client(['handler' => $handlerStack]),
        ]);

        $participantsAddedResponse = $sdk->team($testTeamID)->subject($testSubjectID)->participantsAdd(new UserCollection(
            [
                Participant::user('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::department('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::accessList('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::bot('ebfaf836-f07b-4df5-809c-2bedb4a2f924')
            ]
        ));

        self::assertEquals($featureParticipantsAddResponse->getCount(), $participantsAddedResponse->getCount());
        self::assertEquals($featureParticipantsAddResponse->getAffected(), $participantsAddedResponse->getAffected());

        foreach ($container as $transaction) {
            /** @var Request $request */
            $request = $transaction['request'];
            self::assertEquals(
                'https://api.amo.io/v1.3/subjects/' . $testSubjectID . '/participants',
                (string)$request->getUri(),
            );
            self::assertEquals(
                'PUT',
                $request->getMethod(),
            );
        }
    }

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
            'participants' => new UserCollection([
                Participant::department('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::accessList('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::bot('ebfaf836-f07b-4df5-809c-2bedb4a2f924')
            ]),
            'subscribers' => new UserCollection([
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
            'participants' => new UserCollection([
                Participant::department('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::accessList('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::bot('ebfaf836-f07b-4df5-809c-2bedb4a2f924')
            ]),
            'subscribers' => new UserCollection([
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
