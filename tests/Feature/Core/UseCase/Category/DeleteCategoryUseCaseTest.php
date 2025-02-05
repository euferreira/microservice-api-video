<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\DeleteCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteCategoryUseCaseTest extends TestCase
{

    public function test_delete(): void
    {
        $categoryDb = Model::factory()->create();

        $reposiory = new CategoryEloquentRepository(new Model());
        $useCase = new DeleteCategoryUseCase($reposiory);

        $response = $useCase->execute(new CategoryInputDto(
            id: $categoryDb->id,
        ));

        $this->assertSoftDeleted('categories', [
            'id' => $categoryDb->id,
        ]);

        $this->assertTrue($response->success);
    }
}
