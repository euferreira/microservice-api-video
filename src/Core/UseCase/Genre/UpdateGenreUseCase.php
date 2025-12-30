<?php

namespace Core\UseCase\Genre;

use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\UseCase\DTO\Genre\Update\GenreUpdateInputDto;
use Core\UseCase\DTO\Genre\Update\GenreUpdateOutputDto;
use Core\UseCase\Interfaces\TransactionInterface;
use Throwable;

class UpdateGenreUseCase
{
    public function __construct(
        protected GenreRepositoryInterface    $repository,
        protected TransactionInterface        $transaction,
        protected CategoryRepositoryInterface $categoryRepository,
    )
    {
    }

    public function execute(GenreUpdateInputDto $input): GenreUpdateOutputDto
    {
        $genre = $this->repository->findById($input->id);

        try {
            $genre->update(
                name: $input->name,
            );
            foreach ($input->categoriesId as $categoryId) {
                $genre->addCategory($categoryId);
            }

            $this->validateCategoriesId($input->categoriesId);

            $genreDb = $this->repository->update($genre);
            $this->transaction->commit();

            return new GenreUpdateOutputDto(
                id: (string)$genreDb->id,
                name: $genreDb->name,
                categoriesIds: $genreDb->categoriesId,
            );
        } catch (Throwable $exception) {
            $this->transaction->rollback();
            throw $exception;
        }
    }

    public function validateCategoriesId(array $categoriesId = []): void
    {
        $categoriesDb = $this->categoryRepository->getIdsListIds($categoriesId);
        $arrayDiff = array_diff($categoriesId, $categoriesDb);

        if (count($arrayDiff)) {
            $msg = sprintf(
                '%s %s not found',
                count($arrayDiff) > 1 ? 'Categories' : 'Category',
                implode(', ', $arrayDiff)
            );
            throw new NotFoundException($msg);
        }
    }
}
