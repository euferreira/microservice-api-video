<?php

namespace Core\UseCase\Genre;

use Core\Domain\Entity\Genre;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\UseCase\DTO\Genre\Create\GenreInputCreateDto;
use Core\UseCase\DTO\Genre\Create\GenreOutputCreateDto;
use Core\UseCase\Interfaces\TransactionInterface;
use Throwable;

class CreateGenreUseCase
{
    public function __construct(
        protected GenreRepositoryInterface    $repository,
        protected TransactionInterface        $transaction,
        protected CategoryRepositoryInterface $categoryRepository,
    )
    {
    }

    /**
     * @throws Throwable
     * @throws NotFoundException
     */
    public function execute(GenreInputCreateDto $input): GenreOutputCreateDto
    {
        try {
            $genre = new Genre(
                name: $input->name,
                isActive: $input->isActive,
                categoriesId: $input->categoriesId,
            );
            $this->validateCategoriesId($input->categoriesId);

            $genreDb = $this->repository->insert($genre);

            $this->transaction->commit();
            return new GenreOutputCreateDto(
                id: (string)$genreDb->id,
                name: $genreDb->name,
                is_active: $genreDb->isActive,
                created_at: $genreDb->createdAt(),
            );
        } catch (Throwable $exception) {
            $this->transaction->rollback();
            throw $exception;
        }
    }

    public function validateCategoriesId(array $categoriesId = []): void
    {
        $categoriesDb = $this->categoryRepository->getIdsListIds($categoriesId);

        if (count($categoriesDb) !== count($categoriesId)) {
            throw new NotFoundException('Category not found');
        }
    }
}
