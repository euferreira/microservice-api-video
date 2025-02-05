<?php

namespace Core\UseCase\DTO\Category\CreateCategory;

class CategoryCreateOutputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string|\DateTime $created_at = '',
        public string $description = '',
        public bool   $is_active = true,
    )
    {
    }
}
