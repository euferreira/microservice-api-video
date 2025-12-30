<?php

namespace Tests\Unit\UseCase\Genre;

use Core\Domain\Repository\GenreRepositoryInterface;
use Core\UseCase\DTO\Genre\Delete\DeleteGenreOutputDto;
use Core\UseCase\DTO\Genre\GenreInputDto;
use Core\UseCase\Genre\DeleteGenreUseCase;
use Ramsey\Uuid\Uuid;
use stdClass;
use Tests\TestCase;

class DeleteGenreUseCaseUnitTest extends TestCase
{
    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function test_delete()
    {
        $uuid = (string) Uuid::uuid4();

        $mockRepository = \Mockery::mock(stdClass::class, GenreRepositoryInterface::class);
        $mockRepository->shouldReceive('delete')
            ->once()
            ->with($uuid)
            ->andReturn(true);

        $mockInputDto = \Mockery::mock(GenreInputDto::class, [
            $uuid
        ]);

        $useCase = new DeleteGenreUseCase($mockRepository);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(DeleteGenreOutputDto::class, $response);
        $this->assertTrue($response->success);
    }

    public function test_delete_fail()
    {
        $uuid = (string) Uuid::uuid4();

        $mockRepository = \Mockery::mock(stdClass::class, GenreRepositoryInterface::class);
        $mockRepository->shouldReceive('delete')
            ->times(1)
            ->with($uuid)
            ->andReturn(false);

        $mockInputDto = \Mockery::mock(GenreInputDto::class, [
            $uuid
        ]);

        $useCase = new DeleteGenreUseCase($mockRepository);
        $response = $useCase->execute($mockInputDto);

        $this->assertFalse($response->success);
    }
}
