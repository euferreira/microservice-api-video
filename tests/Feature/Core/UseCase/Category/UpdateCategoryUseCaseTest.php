<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\UpdateCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Core\UseCase\DTO\Category\UpdateCategory\CategoryUpdateInputDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCategoryUseCaseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_update(): void
    {
        $categoryDb = Model::factory()->create();

        $repository = new CategoryEloquentRepository(new Model());
        $useCase = new UpdateCategoryUseCase($repository);
        $response = $useCase->execute(new CategoryUpdateInputDto(
            id: $categoryDb->id,
            name: 'Category Updated',
            description: 'Description Updated'
        ));

        $this->assertEquals($categoryDb->id, $response->id);
        $this->assertEquals('Category Updated', $response->name);
        $this->assertEquals('Description Updated', $response->description);

        $this->assertDatabaseHas('categories', [
            'id' => $response->id,
            'name' => $response->name,
            'description' => $response->description
        ]);
    }
}
