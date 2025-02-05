<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\DTO\Category\CreateCategory\CategoryCreateInputDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCategoryUseCaseTest extends TestCase
{
    public function test_create(): void
    {
        $reposiory = new CategoryEloquentRepository(new Model());
        $useCase = new CreateCategoryUseCase($reposiory);

        $response = $useCase->execute(new CategoryCreateInputDto(
            name: 'Category 1',
        ));

        $this->assertEquals('Category 1', $response->name);
        $this->assertNotEmpty($response->id);

        $this->assertDatabaseHas('categories', [
            'name' => 'Category 1',
        ]);
    }
}
