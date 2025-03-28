<?php

namespace Tests\Feature\Core\UseCase\Category;


use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListCategoryUseCaseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $categoryDB = Model::factory()->create();

        $repository = new CategoryEloquentRepository(new Model());
        $useCase = new ListCategoryUseCase($repository);
        $response = $useCase->execute(new CategoryInputDto(
            id: $categoryDB->id
        ));

        $this->assertEquals($categoryDB->id, $response->id);
        $this->assertEquals($categoryDB->name, $response->name);
        $this->assertEquals($categoryDB->description, $response->description);
    }
}
