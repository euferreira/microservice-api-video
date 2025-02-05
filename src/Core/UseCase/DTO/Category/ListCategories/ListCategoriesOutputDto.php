<?php

namespace Core\UseCase\DTO\Category\ListCategories;

class ListCategoriesOutputDto
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
