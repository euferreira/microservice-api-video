<?php

namespace Tests\Feature\App\Http\Controllers\Api;

use App\Http\Controllers\Api\CategoryController;
use App\Http\Requests\{
    StoreCategoryRequest,
    UpdateCategoryRequest
};
use App\Models\Category;
use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\{CreateCategoryUseCase,
    DeleteCategoryUseCase,
    ListCategoriesUseCase,
    ListCategoryUseCase,
    UpdateCategoryUseCase};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    protected CategoryEloquentRepository $repository;
    protected CategoryController $controller;

    protected function setUp(): void
    {
        $model = new Model();
        $this->repository = new CategoryEloquentRepository($model);
        $this->controller = new CategoryController();

        parent::setUp();
    }

    public function test_index(): void
    {
        $useCase = new ListCategoriesUseCase($this->repository);
        $response = $this->controller->index(new Request(), $useCase);

        $this->assertInstanceOf(AnonymousResourceCollection::class, $response);
        $this->assertArrayHasKey('meta', $response->additional);
    }

    public function test_store()
    {
        $useCase = new CreateCategoryUseCase($this->repository);
        $request = new StoreCategoryRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setMethod('POST');
        $request->setJson(new InputBag([
            'name' => 'Category 1',
            'description' => 'Description 1',
        ]));

        $response = $this->controller->store($request, $useCase);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(ResponseAlias::HTTP_CREATED, $response->status());
    }

    public function test_show()
    {
        $category = Category::factory()->create();
        $useCase = new ListCategoryUseCase($this->repository);

        $response = $this->controller->show(
            id: $category->id,
            useCase: $useCase,
        );

        $this->assertEquals(200, $response->status());
    }

    public function test_update()
    {
        $categoryDb = Category::factory()->create();
        $request = new UpdateCategoryRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setMethod('PUT');
        $request->setJson(new InputBag([
            'name' => 'Category 1',
            'description' => 'Description 1',
        ]));

        $response = $this->controller->update(
            request: $request,
            id: $categoryDb->id,
            useCase: new UpdateCategoryUseCase($this->repository)
        );

        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('categories', [
            'name' => 'Category 1',
            'description' => 'Description 1',
        ]);
    }

    public function test_delete()
    {
        $category = Category::factory()->create();
        $response = $this->controller->destroy(
            id: $category->id,
            useCase: new DeleteCategoryUseCase($this->repository)
        );

        $this->assertEquals(204, $response->status());
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
        ]);
    }
}
