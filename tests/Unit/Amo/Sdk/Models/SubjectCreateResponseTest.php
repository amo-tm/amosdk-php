<?php

namespace Tests\Unit\Amo\Sdk\Models;

use Amo\Sdk\Models\SubjectCreateResponse;
use GuzzleHttp\Psr7\Utils;
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
                                "title": "name"
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
    "title": "THIW IS SUBJECT",
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

        $subjectResponse = SubjectCreateResponse::fromStream(Utils::streamFor($this->data));
        print_r($subjectResponse->getParticipants());
    }
}
