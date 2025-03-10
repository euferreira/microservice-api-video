<?php

namespace Core\UseCase\Genre;

use Core\Domain\Repository\GenreRepositoryInterface;
use Core\UseCase\DTO\Genre\GenreInputDto;
use Core\UseCase\DTO\Genre\GenreOutputDto;

class ListGenreUseCase
{
    public function __construct(protected GenreRepositoryInterface $repository)
    {
    }

    public function execute(GenreInputDto $input): GenreOutputDto
    {
        $response = $this->repository->findById($input->id);

        return new GenreOutputDto(
            id: (string)$response->id,
            name: $response->name,
            is_active: $response->isActive,
            created_at: $response->createdAt(),
        );
    }

}
