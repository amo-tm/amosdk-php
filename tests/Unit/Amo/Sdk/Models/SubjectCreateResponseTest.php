<?php

namespace Tests\Unit\Amo\Sdk\Models;

use Amo\Sdk\Models\Participant;
use Amo\Sdk\Models\ParticipantResponse;
use Amo\Sdk\Models\SubjectCreateResponse;
use Amo\Sdk\Models\SubjectStatus;
use Amo\Sdk\Models\SubjectStatusCollection;
use Amo\Sdk\Models\SubjectThread;
use Amo\Sdk\Models\SubjectThreadCollection;
use GuzzleHttp\Psr7\Utils;
use phpDocumentor\Reflection\Types\Array_;
use PHPUnit\Framework\TestCase;

class SubjectCreateResponseTest extends TestCase
{
    protected  string $data = '
 {
    "_embedded": {
        "participants": {
            "count": 1
        },
        "subscribers": {
            "count": 1
        },
        "threads": {
            "_embedded": {
                "threads": [
                    {
                        "_embedded": {
                            "thread": {
                                "id": "3adcf606-6728-11ec-ad58-00e04ceb7767",
                                "title": "THREAD NUMBER ONE"
                            }
                        },
                        "thread_id": "3adcf606-6728-11ec-ad58-00e04ceb7767"
                    },
                    {
                        "_embedded": {
                            "thread": {
                                "id": "3adcf606-6728-11ec-ad58-00e04ceb7767",
                                "title": "THREAD NUMBER TWO"
                            }
                        },
                        "thread_id": "3adcf606-6728-11ec-ad58-00e04ceb7767"
                    }
                ]
            },
            "count": 1
        }
    },
    "id": "3adcd254-6728-11ec-ad58-00e04ceb7767",
    "title": "THIS IS SUBJECT",
    "external_link": "https://google.com",
    "created_by": 1640618302000,
    "updated_at": 1640618302000,
    "status": [
        {
            "title": "TITLE",
            "color_hex": "#AE70A0"
        },
        {
            "title": "SECOND TITLE",
            "color_hex": "#71C7EC"
        }
    ],
    "author": {
        "_embedded": {
            "user": {
                "id": "218a98bc-3a0a-11eb-a9a1-00163e18b446"
            }
        },
        "user_id": "218a98bc-3a0a-11eb-a9a1-00163e18b446"
    }
}';
    public function testDecode() {
        $subject = new SubjectCreateResponse([
            "id" => "3adcd254-6728-11ec-ad58-00e04ceb7767",
            "title" => "THIS IS SUBJECT",
            "external_link" => "https://google.com",
            "created_by" => 1640618302000,
            "updated_at" => 1640618302000,
            "status" => new SubjectStatusCollection([
                new SubjectStatus([
                    "title" => "TITLE",
                    "color_hex" => "#AE70A0"
                ]),
                new SubjectStatus([
                    "title" => "SECOND TITLE",
                    "color_hex" => "#71C7EC"
                ]),
            ]),
            "author" => new Participant([
                "user_id" => "218a98bc-3a0a-11eb-a9a1-00163e18b446"
            ]),
            "thread_array" => [
                new SubjectThread([
                    "id" => "3adcf606-6728-11ec-ad58-00e04ceb7767",
                    "title" => "THREAD NUMBER ONE"
                ]),
                new SubjectThread([
                    "id" => "3adcf606-6728-11ec-ad58-00e04ceb7767",
                    "title" => "THREAD NUMBER TWO"
                ])
            ]
        ]);

        $subjectResponse = SubjectCreateResponse::fromStream(Utils::streamFor($this->data));


        self::assertEquals($subject->getId(), $subjectResponse->getId());
        self::assertEquals($subject->getAuthor(), $subjectResponse->getAuthor());
        self::assertEquals($subject->getStatus(), $subjectResponse->getStatus());
        self::assertEquals($subject->getThreads(), $subjectResponse->getThreads());
        self::assertEquals($subject->getTitle(), $subjectResponse->getTitle());
    }

}
