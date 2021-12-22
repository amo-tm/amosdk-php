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
      "_embedded": {
        "participants": [
          {
            "_embedded": {
              "user": {
                "id": "218a98bc-3a0a-11eb-a9a1-00163e18b446"
              }
            },
            "user_id": "218a98bc-3a0a-11eb-a9a1-00163e18b446"
          },
          {
            "_embedded": {
              "department": {
                "id": "04469c3e-5f2e-11ec-bf63-0242ac130002"
              }
            },
            "department_id": "04469c3e-5f2e-11ec-bf63-0242ac130002"
          },
          {
            "_embedded": {
              "access_list": {
                "id": "0eba2bd6-5f2e-11ec-bf63-0242ac130002"
              }
            },
            "access_list_id": "0eba2bd6-5f2e-11ec-bf63-0242ac130002"
          },
          {
            "_embedded": {
              "bot": {
                "id": "124479fa-5f2e-11ec-bf63-0242ac130002"
              }
            },
            "bot_id": "124479fa-5f2e-11ec-bf63-0242ac130002"
          }
        ]
      },
      "count": 4
    },
    "subscribers": {
      "_embedded": {
        "subscribers": [
          {
            "_embedded": {
              "user": {
                "id": "ebfaf836-f07b-4df5-809c-2bedb4a2f924"
              }
            },
            "user_id": "ebfaf836-f07b-4df5-809c-2bedb4a2f924"
          },
          {
            "_embedded": {
              "department": {
                "id": "04469c3e-5f2e-11ec-bf63-0242ac130002"
              }
            },
            "department_id": "04469c3e-5f2e-11ec-bf63-0242ac130002"
          },
          {
            "_embedded": {
              "access_list": {
                "id": "0eba2bd6-5f2e-11ec-bf63-0242ac130002"
              }
            },
            "access_list_id": "0eba2bd6-5f2e-11ec-bf63-0242ac130002"
          },
          {
            "_embedded": {
              "bot": {
                "id": "124479fa-5f2e-11ec-bf63-0242ac130002"
              }
            },
            "bot_id": "124479fa-5f2e-11ec-bf63-0242ac130002"
          }
        ]
      },
      "count": 4
    },
    "threads": {
      "_embedded": {
        "threads": [
          {
            "_embedded": {
              "thread": {
                "id": "8e287677-6273-11ec-9ca4-00e04ceb7767",
                "title": "Subject Thread #1"
              }
            },
            "thread_id": "8e287677-6273-11ec-9ca4-00e04ceb7767"
          },
          {
            "_embedded": {
              "thread": {
                "id": "8e704456-6273-11ec-9ca4-00e04ceb7767",
                "title": "Subject Thread #2"
              }
            },
            "thread_id": "8e704456-6273-11ec-9ca4-00e04ceb7767"
          }
        ]
      },
      "count": 2
    }
  },
  "id": "8e28762a-6273-11ec-9ca4-00e04ceb7767",
  "title": "Subject Title",
  "external_link": "https://example.com/",
  "created_by": 1640100898000,
  "updated_at": 1640100898000,
  "status": [
    {
      "title": "Status",
      "color_hex": "#F9F6EE"
    },
    {
      "title": "Title",
      "color_hex": "#CFE1A7"
    }
  ],
  "author": {
    "_embedded": {
      "user": {
        "id": "d5a96370-b613-4289-9b2c-6957251f8089"
      }
    },
    "user_id": "d5a96370-b613-4289-9b2c-6957251f8089"
  }
}';

    public function testDecode() {

        print SubjectCreateResponse::fromStream(Utils::streamFor($this->data))->getEmbedded();
    }
}
