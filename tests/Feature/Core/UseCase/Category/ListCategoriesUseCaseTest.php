<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\ListCategories\ListCategoriesInputDto;
use Core\UseCase\DTO\Category\ListCategories\ListCategoriesOutputDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListCategoriesUseCaseTest extends TestCase
{
    public function test_list_categories_empty(): void
    {
        $response = $this->createUseCase();

        $this->assertCount(0, $response->items);
    }

    public function test_list_categories_all(): void
    {
        $categoriesDb = Model::factory()->count(20)->create();
        $response = $this->createUseCase();

        $this->assertCount(15, $response->items);
        $this->assertEquals(count($categoriesDb), $response->total);
    }

    private function createUseCase(): ListCategoriesOutputDto
    {
        $repository = new CategoryEloquentRepository(new Model());
        $useCase = new ListCategoriesUseCase($repository);
        return $useCase->execute(new ListCategoriesInputDto());
    }
}
