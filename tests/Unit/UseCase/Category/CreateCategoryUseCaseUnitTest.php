<?php

namespace tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\DTO\Category\CreateCategory\CategoryCreateInputDto;
use Core\UseCase\DTO\Category\CreateCategory\CategoryCreateOutputDto;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateCategoryUseCaseUnitTest extends TestCase
{
    public function testCreateNewCategory()
    {
        $uuid = Uuid::uuid4()->toString();
        $categoryName = 'Category 1';
        $this->mockEntity = \Mockery::mock(Category::class, [
            $uuid,
            $categoryName,
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($uuid);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepo = \Mockery::mock(\stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('insert')
            ->andReturn($this->mockEntity);

        $this->mockInputDto = \Mockery::mock(CategoryCreateInputDto::class, [
            $categoryName,
        ]);

        $useCase = new CreateCategoryUseCase($this->mockRepo);
        $responseUsecase = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(CategoryCreateOutputDto::class, $responseUsecase);
        $this->assertTrue(true);

        /*
         * Spies
         * */
        $this->spy = \Mockery::spy(\stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('insert')
            ->andReturn($this->mockEntity);
        $useCase = new CreateCategoryUseCase($this->spy);
        $responseUsecase = $useCase->execute($this->mockInputDto);
        $this->spy->shouldHaveReceived('insert')->once();

        \Mockery::close();
    }
}
