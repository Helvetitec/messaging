<?php

namespace Helvetitec\Messaging\Whatsapp\Responses\Uazapi;

use Illuminate\Support\Collection;

class PaginatedResponse
{
    public readonly Collection $items;
    public readonly int $totalRecords;
    public readonly int $pageSize;
    public readonly int $currentPage;
    public readonly int $totalPages;
    public readonly bool $hasNextPage;
    public readonly bool $hasPreviousPage;

    public function __construct(
        Collection $items,
        int $totalRecords,
        int $pageSize,
        int $currentPage,
        int $totalPages,
        bool $hasNextPage,
        bool $hasPreviousPage,
    )
    {
        $this->items = $items;
        $this->totalRecords = $totalRecords;
        $this->pageSize = $pageSize;
        $this->currentPage = $currentPage;
        $this->totalPages = $totalPages;
        $this->hasNextPage = $hasNextPage;
        $this->hasPreviousPage = $hasPreviousPage;
    }
}