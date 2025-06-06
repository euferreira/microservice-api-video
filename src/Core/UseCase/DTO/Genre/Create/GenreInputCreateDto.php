<?php

namespace Core\UseCase\DTO\Genre\Create;

class GenreInputCreateDto
{
    public function __construct(
        public string $name,
        public array $categoriesId = [],
        public bool   $isActive = true,
    )
    {
    }
}
