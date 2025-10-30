<?php

declare(strict_types=1);

namespace Amo\Sdk\Filters\Traits;

trait PagesFilter
{
    private int $limit = 50;

    private ?string $pageToken = null;

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getPageToken(): ?string
    {
        return $this->pageToken;
    }

    public function setLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function setPageToken(string $pageToken): self
    {
        $this->pageToken = $pageToken;
        return $this;
    }

    public function buildPagesFilter(array $filter = []): array
    {
        if (!empty($this->getLimit())) {
            $filter['limit'] = $this->getLimit();
        }

        if (!empty($this->getPageToken())) {
            $filter['page_token'] = $this->getPageToken();
        }

        return $filter;
    }
}
