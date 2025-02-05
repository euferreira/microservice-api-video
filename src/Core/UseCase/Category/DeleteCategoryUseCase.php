<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Core\UseCase\DTO\Category\DeleteCategory\CategoryDeleteOutputDto;

class DeleteCategoryUseCase
{
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function execute(CategoryInputDto $inputDto): CategoryDeleteOutputDto
    {
         $responseDelete = $this->categoryRepository->delete($inputDto->id);

        return new CategoryDeleteOutputDto(
            success: $responseDelete,
        );
    }
}
