<?php

declare(strict_types=1);

namespace Amo\Sdk\Filters;

class UsersFilter extends AbstractFilter
{
    private ?array $ids = null;

    public function setIds(array $ids): self
    {
        $this->ids = $ids;

        return $this;
    }

    public function getIds(): ?array
    {
        return $this->ids;
    }

    public function buildFilter(): array
    {
        $filter = [];

        if (!empty($this->getIds())) {
            $filter['user_ids'] = $this->getIds();
        }

        return $filter;
    }

    public function buildQueryFilter(): string
    {
        $filter = $this->buildFilter();
        if (empty($filter)) {
            return '';
        }

        $queryParams = http_build_query(
            $filter,
            "",
            '&',
            PHP_QUERY_RFC3986
        );

        return preg_replace('/(%5B)\d+(%5D=)/i','$1$2',$queryParams);
    }
}
