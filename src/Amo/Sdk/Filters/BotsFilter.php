<?php

declare(strict_types=1);

namespace Amo\Sdk\Filters;

class BotsFilter extends AbstractFilter
{
    use Traits\PagesFilter;

    private ?string $query = null;

    public function setQuery(string $query): self
    {
        $this->query = $query;

        return $this;
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function buildFilter(): array
    {
        $filter = [];

        if (!empty($this->getQuery())) {
            $filter['query'] = $this->getQuery();
        }

        return $this->buildPagesFilter($filter);
    }
}
