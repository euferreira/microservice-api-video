<?php

namespace Tests\Unit\UseCase\Genre;

use Core\Domain\Repository\GenreRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Core\UseCase\DTO\Genre\List\{
    ListGenresInputDto,
    ListGenresOutputDto
};
use Core\UseCase\Genre\ListGenresUseCase;
use PHPUnit\Framework\TestCase;

class ListGenresUsecaseUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_usecase(): void
    {
        $mockRepository = \Mockery::mock(\stdClass::class, GenreRepositoryInterface::class);
        $mockRepository->shouldReceive('paginate')->andReturn($this->mockPagination());

        $mockDtoInput = \Mockery::mock(ListGenresInputDto::class, [
            'teste', 'desc', 1, 15
        ]);

        $usecase = new ListGenresUseCase($mockRepository);
        $response = $usecase->execute($mockDtoInput);

        $this->assertInstanceOf(ListGenresOutputDto::class, $response);
        \Mockery::close();
    }

    protected function mockPagination(array $items = [])
    {
        $this->mockPagination = \Mockery::mock(\stdClass::class, PaginationInterface::class);
        $this->mockPagination->shouldReceive('items')->andReturn($items);
        $this->mockPagination->shouldReceive('total')->andReturn(0);
        $this->mockPagination->shouldReceive('firstPage')->andReturn(0);
        $this->mockPagination->shouldReceive('currentPage')->andReturn(0);
        $this->mockPagination->shouldReceive('lastPage')->andReturn(0);
        $this->mockPagination->shouldReceive('perPage')->andReturn(0);
        $this->mockPagination->shouldReceive('to')->andReturn(0);
        $this->mockPagination->shouldReceive('from')->andReturn(0);

        return $this->mockPagination;
    }
}
