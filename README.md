# amo | team messenger PHP sdk

[![Build Status](https://travis-ci.org/amo-tm/amosdk-php.svg?branch=master)](https://travis-ci.org/amo-tm/amosdk-php)
[![Latest Stable Version](https://poser.pugx.org/amo-tm/amosdk-php/v/stable.svg)](https://packagist.org/packages/amo-tm/amosdk-php)
[![Total Downloads](https://poser.pugx.org/amo-tm/amosdk-php/downloads.svg)](https://packagist.org/packages/amo-tm/amosdk-php)
[![License](https://poser.pugx.org/amo-tm/amosdk-php/license.svg)](https://packagist.org/packages/amo-tm/amosdk-php)
[![Code Coverage](https://coveralls.io/repos/amo-tm/amosdk-php/badge.svg?branch=master)](https://coveralls.io/r/amo-tm/amosdk-php?branch=master)

## Requirements

PHP 7.4.0 and later.

## Composer

You can install the sdk via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require amo-tm/amosdk-php@1.0.0-BETA
```

To use the sdk, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Getting Started

Simple usage:

```php
use \Amo\Sdk\AmoClient;

$sdk = new AmoClient([
    'clientID' => 'your_client_id',
    'clientSecret' => 'your_client_secret',
]);
```

Initiate client with access token:

```php
use \Amo\Sdk\AmoClient;
use \League\OAuth2\Client\Token\AccessToken;

// Token fetch from store
/** @var AccessToken $accessToken */
$accessToken = null;

$sdk = new AmoClient([
    'clientID' => 'your_client_id',
    'clientSecret' => 'your_client_secret',
    'accessToken' => $accessToken,
]);
```

## Receive appToken

This type of tokens issued by client library. Your can issue token on every request or store them in your datastore.

```php
use \Amo\Sdk\AmoClient;

$sdk = new AmoClient([
    'clientID' => 'your_client_id',
    'clientSecret' => 'your_client_secret',
]);

$appScopedSdk = $sdk->withToken($sdk->getApplicationToken())
// store token in database
```

## Team create

> **REQUIRED:** AppToken
>
> **SCOPE:** teams

```php
use \Amo\Sdk\AmoClient;
use \Amo\Sdk\Models\Team;

$sdk = new AmoClient([
    'clientID' => 'your_client_id',
    'clientSecret' => 'your_client_secret',
]);

$appScopedSdk = $sdk->withToken($sdk->getApplicationToken())
$newTeam = $appScopedSdk->team()->create(new Team([
    'title' => 'testTeamName'
]))

print "team created with id " . $newTeam->getId();
```

## Profile create

> **REQUIRED:** AppToken
>
> **SCOPE:** profiles

```php
use \Amo\Sdk\AmoClient;
use \Amo\Sdk\Models\Team;

$sdk = new AmoClient([
    'clientID' => 'your_client_id',
    'clientSecret' => 'your_client_secret',
]);

$appScopedSdk = $sdk->withToken($sdk->getApplicationToken())
$createdProfile = $appScopedSdk->profile()->create(new Profile([
    'name' => 'Tim',
    'email' => 'tim@domain.com',
    'external_id' => '7688d6ac-57a1-421e-ac41-a68205d96d4e'
]));

print "profile created with id " . $createdTeam->getId();
```

## Invite profile to team

> **REQUIRED:** TeamToken
>
> **SCOPE:** profiles,teams

```php
/** @var \Amo\Sdk\AmoClient $appScopedSdk */
$teamService = $appScopedSdk->team($newTeam->getId())->scope();

// save team token to datastore 
$teamToken = $teamService->getAccessToken();

$invitedUser = $teamService->invite($createdProfile->getId(), new TeamProps([
    'is_admin' => true,
    'position' => 'CEO'
]));
```

## Kick profile from team

> **REQUIRED:** TeamToken
>
> **SCOPE:** profiles,teams

```php
/** @var \Amo\Sdk\Service\TeamService $teamService */
$teamService->kick($invitedUser->getId());
```

## Subject create

> **REQUIRED:** TeamToken
> 
> **SCOPE:** teams

```php
/** @var \Amo\Sdk\Service\TeamService $teamService */
$subjectsService = $teamService->subjectService();

$newSubject = $subjectsService->create(new Subject([
    'title' => 'Subject Title',
    'external_link' => 'https://example.com/',
    'author' => Participant::user($createdProfile->getId()),
    'participants' => array(
        Participant::user($createdProfile->getId()),
        Participant::department('04469c3e-5f2e-11ec-bf63-0242ac130002'),
        Participant::accessList('0eba2bd6-5f2e-11ec-bf63-0242ac130002'),
        Participant::bot('124479fa-5f2e-11ec-bf63-0242ac130002'),
    ),
    'subscribers' => array(
        Participant::user('ebfaf836-f07b-4df5-809c-2bedb4a2f924'),
        Participant::department('04469c3e-5f2e-11ec-bf63-0242ac130002'),
        Participant::accessList('0eba2bd6-5f2e-11ec-bf63-0242ac130002'),
        Participant::bot('124479fa-5f2e-11ec-bf63-0242ac130002'),
    ),
    'threads' => array(
        new SubjectThreadCreateRequest(
            [
                'title' => 'Thread Title',
                'avatar_url' => 'https://picsum.photos/600'
            ]

        )
    ),
    'status' => array(
        new SubjctStatus(
            [
                'title' => 'Status Title',
                'color' => '#F37553'
            ]
        )
    ),
]));

print "subject created with id " . $newSubject->getId();
```