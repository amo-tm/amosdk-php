<?php

namespace Unit\Amo\Sdk\Service;

use Amo\Sdk\AmoClient;
use Amo\Sdk\Models\ParticipantCollection;
use Amo\Sdk\Models\Subject;
use Amo\Sdk\Models\Participant;
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

        $createdSubject = $sdk->team()->subject()->create(new Subject([
            'title' => 'Subject Title',
            'external_link' => 'https://example.com/',
            'author' =>  Participant::user('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
            'participants' => new ParticipantCollection([
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

        self::assertEquals($featureSubject->getId(), $createdSubject->getId());
        self::assertEquals($featureSubject->getTitle(), $createdSubject->getTitle());
        self::assertEquals($featureSubject->getAuthor(), $createdSubject->getAuthor());
        self::assertEquals($featureSubject->getAuthor(), $createdSubject->getAuthor());

        foreach ($container as $transaction) {
            /** @var Request $request */
            $request = $transaction['request'];
            self::assertEquals(
                'https://api.amo.io/v1.3/team/' . $testTeamID . '/subjects',
                (string)$request->getUri(),
            );
            self::assertEquals(
                'POST',
                $request->getMethod(),
            );
        }
    }
}
