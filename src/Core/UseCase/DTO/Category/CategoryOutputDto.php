<?php

namespace Core\UseCase\DTO\Category;

use DateTime;

class CategoryOutputDto
{
    public function __construct(
        public string          $id,
        public string          $name,
        public string          $description = '',
        public bool            $is_active  = true,
        public string|DateTime $created_at = '',
    )
    {
    }
}
