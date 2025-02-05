<?php

namespace Core\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\DTO\Category\UpdateCategory\CategoryUpdateInputDto;
use Core\UseCase\DTO\Category\UpdateCategory\CategoryUpdateOutputDto;

class UpdateCategoryUseCase
{
    private CategoryRepositoryInterface $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function execute(CategoryUpdateInputDto $inputDto): CategoryUpdateOutputDto
    {
        $category = $this->categoryRepository->findById($inputDto->id);
        $category->update(
            name: $inputDto->name,
            description: $inputDto->description ?? $category->description,
            isActive: $inputDto->isActive,
        );
        $categoryUpdated = $this->categoryRepository->update($category);

        return new CategoryUpdateOutputDto(
            id: $categoryUpdated->id,
            name: $categoryUpdated->name,
            description: $categoryUpdated->description,
            is_active: $categoryUpdated->isActive,
            created_at: $categoryUpdated->createdAt,
        );
    }
}
