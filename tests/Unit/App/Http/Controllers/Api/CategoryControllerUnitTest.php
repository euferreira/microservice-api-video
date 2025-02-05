<?php

namespace Tests\Unit\App\Http\Controllers\Api;

use App\Http\Controllers\Api\CategoryController;
use Core\UseCase\DTO\Category\ListCategories\ListCategoriesOutputDto;
use Core\UseCase\Category\{
    ListCategoriesUseCase
};
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class CategoryControllerUnitTest extends TestCase
{
    public function test_index(): void
    {
        $mockRequest = \Mockery::mock(Request::class);
        $mockRequest->shouldReceive('get')
            ->andReturn('test');

        $mockDtoOutput = \Mockery::mock(ListCategoriesOutputDto::class, [
            [], 1, 1, 1, 1, 1, 1, 1
        ]);

        $mockUseCase = \Mockery::mock(ListCategoriesUseCase::class);
        $mockUseCase->shouldReceive('execute')
            ->andReturn($mockDtoOutput);

        $controller = new CategoryController();
        $response = $controller->index($mockRequest, useCase: $mockUseCase);

        $this->assertIsObject($response->resource);
        $this->assertArrayHasKey('meta', $response->additional);

        /**
         * Spie
         */
        $mockUseCaseSpy = \Mockery::spy(ListCategoriesUseCase::class);
        $mockUseCaseSpy->shouldReceive('execute')
            ->andReturn($mockDtoOutput);

        $controller->index($mockRequest, useCase: $mockUseCaseSpy);

        $mockUseCaseSpy->shouldHaveReceived('execute')->once();

        \Mockery::close();
    }
}
