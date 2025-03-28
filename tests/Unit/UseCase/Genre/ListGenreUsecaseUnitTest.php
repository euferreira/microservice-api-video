<?php

namespace Tests\Unit\UseCase\Genre;

use Core\Domain\Entity\Genre as EntityGenre;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\UseCase\DTO\Genre\GenreInputDto;
use Core\UseCase\DTO\Genre\GenreOutputDto;
use Core\UseCase\Genre\ListGenreUseCase;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ListGenreUsecaseUnitTest extends TestCase
{
    public function test_list_single(): void
    {
        $uuid = (string) Uuid::uuid4();
        $mockEntity = \Mockery::mock(EntityGenre::class, [
            'teste', new \Core\Domain\ValueObject\Uuid($uuid), true, []
        ]);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $mockRepository = \Mockery::mock(\stdClass::class, GenreRepositoryInterface::class);
        $mockRepository->shouldReceive('findById')->andReturn($mockEntity);
        $mockInputDto = \Mockery::mock(GenreInputDto::class, [
            $uuid,
        ]);

        $useCase = new ListGenreUseCase($mockRepository);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(GenreOutputDto::class, $response);

        \Mockery::close();
    }
}
