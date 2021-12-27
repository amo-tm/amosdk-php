<?php

namespace Amo\Sdk\Service;

use Amo\Sdk\AmoClient;
use Amo\Sdk\Models\ParticipantCollection;
use Amo\Sdk\Models\Subject;
use Amo\Sdk\Models\SubjectCreateResponse;
use Amo\Sdk\Models\SubjectParticipantsResponse;
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
    }

    public function subscribersRemove(ParticipantCollection $participants): SubjectParticipantsResponse {
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
    public function subscribersAdd(ParticipantCollection $participants): SubjectParticipantsResponse {
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
    public function participantsRemove(ParticipantCollection $participants): SubjectParticipantsResponse {
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
    public function participantsAdd(ParticipantCollection $participants): SubjectParticipantsResponse {
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
    public function create(Subject $subject): SubjectCreateResponse
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
}