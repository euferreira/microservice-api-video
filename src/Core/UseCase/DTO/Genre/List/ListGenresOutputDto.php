<?php

namespace Core\UseCase\DTO\Genre\List;

class ListGenresOutputDto
{
    public function __construct(
        public array            $items,
        public int              $total,
        public int              $lastPage,
        public int              $firstPage,
        public int              $currentPage,
        public int              $perPage,
        public int              $to,
        public int              $from,
        public string|\DateTime $createdAt = '',
    )
    {
    }
}
