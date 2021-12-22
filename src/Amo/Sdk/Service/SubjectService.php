<?php

namespace Amo\Sdk\Service;

use Amo\Sdk\AmoClient;
use Amo\Sdk\Models\Subject;
use Amo\Sdk\Models\SubjectCreateResponse;
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
    private function subjectUrl(): string
    {
        if (!$this->teamService) {
            throw new \RuntimeException('TeamService not passed. Please, use sdk->team(..)->subject()');
        }

        $url = $this->teamService->teamUrl('/subjects');

        if ($this->subjectId) {
            $url .= '/' . $this->subjectId;
        }

        return $url;
    }
}