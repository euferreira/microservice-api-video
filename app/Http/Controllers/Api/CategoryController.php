<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Core\UseCase\DTO\Category\CreateCategory\CategoryCreateInputDto;
use Core\UseCase\DTO\Category\UpdateCategory\CategoryUpdateInputDto;
use Core\UseCase\Category\{
    CreateCategoryUseCase,
    DeleteCategoryUseCase,
    ListCategoriesUseCase,
    ListCategoryUseCase,
    UpdateCategoryUseCase
};
use Core\UseCase\DTO\Category\ListCategories\ListCategoriesInputDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index(Request $request, ListCategoriesUseCase $useCase): AnonymousResourceCollection
    {
        $response = $useCase->execute(input: new ListCategoriesInputDto(
            filter: $request->get('filter', ''),
            order: $request->get('order', 'asc'),
            page: (int)$request->get('page', 1),
            perPage: (int)$request->get('per_page', 15)
        ));

        return CategoryResource::collection(collect($response->items))
            ->additional([
                'meta' => [
                    'total' => $response->total,
                    'last_page' => $response->lastPage,
                    'current_page' => $response->currentPage,
                    'per_page' => $response->perPage,
                    'from' => $response->from,
                    'to' => $response->to,
                    'first_page' => $response->firstPage,
                ],
            ]);
    }

    public function store(StoreCategoryRequest $request, CreateCategoryUseCase $useCase): JsonResponse
    {
        $response = $useCase->execute(input: new CategoryCreateInputDto(
            name: $request->name,
            description: $request->description ?? '',
            isActive: (bool) $request->is_active ?? true,
        ));

        return (new CategoryResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ListCategoryUseCase $useCase, $id)
    {
        $category = $useCase->execute(new CategoryInputDto($id));

        return (new CategoryResource($category))
            ->response();
    }

    public function update(UpdateCategoryRequest $request, string $id, UpdateCategoryUseCase $useCase)
    {
        $response = $useCase->execute(new CategoryUpdateInputDto(
            id: $id,
            name: $request->name,
            description: $request->description ?? '',
            isActive: (bool) $request->is_active ?? true,
        ));

        return (new CategoryResource($response))
            ->response();
    }

    public function destroy(string $id, DeleteCategoryUseCase $useCase)
    {
        $useCase->execute(new CategoryInputDto(
            id: $id
        ));

        return response()->noContent();
    }
}
