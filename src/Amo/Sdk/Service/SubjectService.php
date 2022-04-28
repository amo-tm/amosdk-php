<?php

namespace Amo\Sdk\Service;

use Amo\Sdk\AmoClient;
use Amo\Sdk\Models\Participant;
use Amo\Sdk\Models\UserCollection;
use Amo\Sdk\Models\Subject;
use Amo\Sdk\Models\SubjectCreateRequest;
use Amo\Sdk\Models\SubjectCreateResponse;
use Amo\Sdk\Models\SubjectParticipantsResponse;
use Amo\Sdk\Models\User;
use Amo\Sdk\Service\TeamService;
use Amo\Sdk\Traits\ServiceInitializer;

class SubjectService extends AbstractService
{
    protected ?string $subjectId;
    protected TeamService $teamService;

    public function factory(TeamService $teamService, string $subjectId = null)
    {
        $this->subjectId = $subjectId;
        $this->teamService = $teamService;
        $this->apiClient = $teamService->apiClient;
    }

    public function subscribersRemove(UserCollection $participants): SubjectParticipantsResponse {
        $resp = $this->teamService->apiClient->delete($this->subjectUrl('/subscribers'), [
            'body' => $participants
        ]);

        return SubjectParticipantsResponse::fromStream($resp->getBody());
    }

    /**
     * @param ParticipantCollection $participants
     * @return SubjectParticipantsResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function subscribersAdd(UserCollection $participants): SubjectParticipantsResponse {
        $resp = $this->teamService->apiClient->put($this->subjectUrl('/subscribers'), [
            'body' => $participants
        ]);

        return SubjectParticipantsResponse::fromStream($resp->getBody());
    }

    /**
     * @param ParticipantCollection $participants
     * @return SubjectParticipantsResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function participantsRemove(UserCollection $participants): SubjectParticipantsResponse {
        $resp = $this->teamService->apiClient->delete($this->subjectUrl('/participants'), [
            'body' => $participants
        ]);

        return SubjectParticipantsResponse::fromStream($resp->getBody());
    }

    /**
     * @param ParticipantCollection $participants
     * @return SubjectParticipantsResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function participantsAdd(UserCollection $participants): SubjectParticipantsResponse {
        $resp = $this->teamService->apiClient->put($this->subjectUrl('/participants'), [
            'body' => $participants
        ]);

        return SubjectParticipantsResponse::fromStream($resp->getBody());
    }

    /**
     * @param Subject $subject
     * @return SubjectCreateResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(SubjectCreateRequest $subject): SubjectCreateResponse
    {
        $resp = $this->teamService->apiClient->post($this->subjectUrl(), [
            'body' => $subject,
        ]);

        return SubjectCreateResponse::fromStream($resp->getBody());
    }

    /**
     * @return string
     */
    private function subjectUrl($location = ''): string
    {
        if (is_array($location)) {
            $location = implode('/', $location);
        }

        if (!$this->teamService) {
            throw new \RuntimeException('TeamService not passed. Please, use sdk->team(..)->subject()');
        }

        $url = '/subjects';

        if ($this->subjectId) {
            $url .= '/' . $this->subjectId;
        }

        if ($location != '') {
            $url .= '/' . ltrim($location, '/');
        }

        return $url;
    }

    /**
     * @var Participant|User|string $user
     */
    public function embedUserToken($user): string {
        if ($user instanceof Participant) {
            $userId = $user->getId();
        } else if ($user instanceof User) {
            $userId = $user->getId();
        } else {
            $userId = $user;
        }

        $signatureBody = implode(':', [
            $this->teamService->getTeamId(),
            $userId,
            $this->subjectId,
        ]);

        return hash_hmac(
            'sha256',
            $signatureBody,
            $this->teamService->apiClient->getClientSecret(),
        );
    }
}
