<?php

namespace Tests\Unit\UseCase\Genre;

use Core\Domain\Entity\Genre as EntityGenre;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\UseCase\DTO\Genre\Create\GenreInputCreateDto;
use Core\UseCase\DTO\Genre\Create\GenreOutputCreateDto;
use Core\UseCase\Genre\CreateGenreUseCase;
use Core\UseCase\Interfaces\TransactionInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateGenreUseCaseUnitTest extends TestCase
{
    public function test_create(): void
    {
        $uuid = (string) Uuid::uuid4();
        $mockEntity = \Mockery::mock(EntityGenre::class, [
            'teste', new \Core\Domain\ValueObject\Uuid($uuid), true, []
        ]);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $mockRepository = \Mockery::mock(\stdClass::class, GenreRepositoryInterface::class);
        $mockRepository->shouldReceive('insert')->andReturn($mockEntity);

        $mockTransaction = \Mockery::mock(\stdClass::class, TransactionInterface::class);
        $mockTransaction->shouldReceive('commit');
        $mockTransaction->shouldReceive('rollback');

        $mockCategoryRepository = \Mockery::mock(\stdClass::class, CategoryRepositoryInterface::class);
        $mockCategoryRepository->shouldReceive('getIdsListIds')->andReturn([$uuid]);

        $usecase = new CreateGenreUseCase(
            $mockRepository,
            $mockTransaction,
            $mockCategoryRepository
        );

        $mockCreateInputDto = \Mockery::mock(GenreInputCreateDto::class, [
            'name', [$uuid], true
        ]);

        $response = $usecase->execute($mockCreateInputDto);

        $this->assertInstanceOf(GenreOutputCreateDto::class, $response);

        \Mockery::close();
    }
}
