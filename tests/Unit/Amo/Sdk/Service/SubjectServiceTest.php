<?php

namespace Unit\Amo\Sdk\Service;

use Amo\Sdk\AmoClient;
use Amo\Sdk\Models\ParticipantInterface;
use Amo\Sdk\Models\Participants;
use Amo\Sdk\Models\Team;
use Amo\Sdk\Models\Subject;
use Amo\Sdk\Models\Participant;
use Amo\Sdk\Models\SubjectStatus;
use Amo\Sdk\Models\SubjectThread;
use Amo\Sdk\Service\SubjectService;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class SubjectServiceTest extends TestCase
{
    public function testCreate()
    {
        $container = [];
        $history = Middleware::history($container);

        $featureSubject = new Subject([
            'id' => Uuid::uuid4()->toString(),
            'title' => 'Subject Title',
            'external_link' => 'https://example.com/',
            'author' => Participant::user('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
            'participants' => new Participants([
                Participant::department('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::accessList('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::bot('ebfaf836-f07b-4df5-809c-2bedb4a2f924')
            ])
        ]);

        print 'default '. $featureSubject;

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

        $createdSubject = $sdk->team()->subject()->create(new Subject([
            'title' => 'Subject Title',
            'external_link' => 'https://example.com/',
            'author' =>  Participant::user('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
            'participants' => new Participants([
                Participant::department('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::accessList('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                Participant::bot('ebfaf836-f07b-4df5-809c-2bedb4a2f924')
            ]),
////            'subscribers' => array(
////                Participant::user('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
////            ),
////            'threads' => array(
////                new SubjectThreadCreateRequest(
////                    [
////                        'title' => 'Thread Title',
////                        'avatar_url' => 'https://picsum.photos/600'
////                    ]
////
////                )
////            ),
////            'status' => array(
////                new SubjectStatus(
////                    [
////                        'title' => 'Status Title',
////                        'color' => '#F37553'
////                    ]
////                )
////            ),
        ]));

        print $createdSubject;

        self::assertEquals($featureSubject->getId(), $createdSubject->getId());
        self::assertEquals($featureSubject->getTitle(), $createdSubject->getTitle());
        self::assertEquals($featureSubject->getAuthor(), $createdSubject->getAuthor());
        self::assertEquals($featureSubject->getAuthor(), $createdSubject->getAuthor());

    }
}
