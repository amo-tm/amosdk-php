<?php

namespace Integration;

use Amo\Sdk\AmoClient;
use Amo\Sdk\Models\Participant;
use Amo\Sdk\Models\UserCollection;
use Amo\Sdk\Models\Profile;
use Amo\Sdk\Models\Subject;
use Amo\Sdk\Models\SubjectStatus;
use Amo\Sdk\Models\SubjectStatusCollection;
use Amo\Sdk\Models\SubjectThread;
use Amo\Sdk\Models\SubjectThreadCollection;
use Amo\Sdk\Models\Team;
use Amo\Sdk\Models\TeamProps;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class SubjectAPITest extends TestCase
{
    public function testCreateSubject()
    {
        $sdk = new AmoClient([
            'clientId' => getenv('AMO_CLIENT_ID'),
            'clientSecret' => getenv('AMO_CLIENT_SECRET'),
            'authURL' => getenv('AMO_AUTH_URL'),
            'baseURL' => getenv('AMO_BASE_URL'),
        ]);

        $appScopedSdk = $sdk->withToken($sdk->getApplicationToken([
            'teams',
            'profiles',
        ]));

        $createdTeam = $appScopedSdk->team()->create(new Team([
            'title' => 'SubjectsTeam'
        ]));


        print "team created with id " . $createdTeam->getId() . "\n";

        $createdProfile = $appScopedSdk->profile()->create(new Profile([
            'name' => 'Subject Manager',
            'email' => 'manager@mailforspam.com',
            'external_id' => 'vasya1'
        ]));

        print "profile created with id " . $createdProfile->getId() . "\n";

        $teamScopeSdk = $appScopedSdk->team($createdTeam->getId())->scope();

        $invitedUser = $teamScopeSdk->invite($createdProfile->getId(), new TeamProps([
            'is_admin' => true,
            'position' => 'CEO'
        ]));

        $createdSubject = $teamScopeSdk->subject()->create(new Subject([
            'title' => 'Subject Title',
            'external_link' => 'https://example.com/',
            'author' => Participant::user($createdProfile),
            'participants' => new UserCollection([
                    Participant::user('218a98bc-3a0a-11eb-a9a1-00163e18b446'),
                    Participant::department('04469c3e-5f2e-11ec-bf63-0242ac130002'),
                    Participant::accessList('0eba2bd6-5f2e-11ec-bf63-0242ac130002'),
                    Participant::bot('124479fa-5f2e-11ec-bf63-0242ac130002'),
                ]),
            'subscribers' => new UserCollection([
                    Participant::user('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
                    Participant::department('04469c3e-5f2e-11ec-bf63-0242ac130002'),
                    Participant::accessList('0eba2bd6-5f2e-11ec-bf63-0242ac130002'),
                    Participant::bot('124479fa-5f2e-11ec-bf63-0242ac130002'),
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

        self::assertEquals("Subject Title", $createdSubject->getTitle());
        self::assertEquals("https://example.com/", $createdSubject->getExternalLink());
        self::assertEquals($createdProfile->getId(), $createdSubject->getAuthor()->getId());

        print "Subject created with id: ". $createdSubject->getId()."\n";

        $subjectService = $teamScopeSdk->subject($createdSubject->getId());

        $participantsAdded = $subjectService->participantsAdd(new UserCollection([
            Participant::user($invitedUser),
        ]));
        print 'Participant Added. Count: '.$participantsAdded->getCount().' Affected: '.$participantsAdded->getAffected()."\n";

//        $participantsRemoved = $subjectService->participantsRemove(new ParticipantCollection([
//            Participant::user($invitedUser),
//        ]));
//        print 'Participant removed. Count: '.$participantsRemoved->getCount().' Affected: '.$participantsRemoved->getAffected()."\n";

        $subscriberAdded = $subjectService->subscribersAdd(new UserCollection([
            Participant::user($invitedUser),
        ]));
        print 'Subscriber Added. Count: '.$subscriberAdded->getCount().' Affected: '.$subscriberAdded->getAffected()."\n";

        print 'Subject embedded user secret: ' . $subjectService->embedUserToken($createdProfile) . "\n";

//        $subscriberRemoved = $subjectService->participantsRemove(new ParticipantCollection([
//            Participant::user($invitedUser),
//        ]));
//        print 'Subscriber removed. Count: '.$subscriberRemoved->getCount().' Affected: '.$subscriberRemoved->getAffected()."\n";
    }
}
