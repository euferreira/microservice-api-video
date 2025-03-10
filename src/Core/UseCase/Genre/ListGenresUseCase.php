<?php

namespace Core\UseCase\Genre;

use Core\Domain\Repository\GenreRepositoryInterface;
use Core\UseCase\DTO\Genre\List\ListGenresInputDto;
use Core\UseCase\DTO\Genre\List\ListGenresOutputDto;

class ListGenresUseCase
{
    public function __construct(protected GenreRepositoryInterface $repository)
    {
    }

    public function execute(ListGenresInputDto $input): ListGenresOutputDto
    {
        $response = $this->repository->paginate(
            filter: $input->filter,
            order: $input->order,
            page: $input->page,
            perPage: $input->perPage,
        );

        return new ListGenresOutputDto(
            items: $response->items(),
            total: $response->total(),
            lastPage: $response->lastPage(),
            firstPage: $response->firstPage(),
            currentPage: $response->currentPage(),
            perPage: $response->perPage(),
            to: $response->to(),
            from: $response->from(),
        );
    }
}
