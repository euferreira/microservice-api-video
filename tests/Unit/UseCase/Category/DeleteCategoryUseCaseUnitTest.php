<?php

namespace UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\DeleteCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Core\UseCase\DTO\Category\DeleteCategory\CategoryDeleteOutputDto;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteCategoryUseCaseUnitTest extends TestCase
{
    public function testDelete()
    {
        $uuid = Uuid::uuid4()->toString();

        $this->mockEntity = \Mockery::mock(Category::class, [
            $uuid,
            'Category Test',
        ]);

        $this->mockRepo = \Mockery::mock(\stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById');
        $this->mockRepo->shouldReceive('delete')->andReturn(true);

        $this->mockInputDto = \Mockery::mock(CategoryInputDto::class, [
            $uuid
        ]);

        $useCase = new DeleteCategoryUseCase($this->mockRepo);
        $responseUseCase = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(CategoryDeleteOutputDto::class, $responseUseCase);
        $this->assertTrue($responseUseCase->success);

        //spies
        $this->spy = \Mockery::spy(CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('findById');
        $this->spy->shouldReceive('delete')->andReturn(true);

        $useCase = new DeleteCategoryUseCase($this->spy);
        $useCase->execute($this->mockInputDto);

        $this->spy->shouldHaveReceived('delete')->once();
    }
}
