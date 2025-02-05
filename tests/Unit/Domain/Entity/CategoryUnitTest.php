<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CategoryUnitTest extends TestCase
{
    public function testAttributes()
    {
        $category = new Category(
            id: Uuid::uuid4()->toString(),
            name: "New Cat",
            description: "New Cat Description",
            isActive: true,
        );

        $this->assertNotEmpty($category->createdAt());
        $this->assertNotEmpty($category->id());
        $this->assertEquals("New Cat", $category->name);
        $this->assertEquals("New Cat Description", $category->description);
        $this->assertEquals(true, $category->isActive);
    }

    public function testActivated()
    {
        $category = new Category(
            id: Uuid::uuid4()->toString(),
            name: "New Cat",
            isActive: false,
        );

        $this->assertFalse($category->isActive);
        $category->activate();
        $this->assertTrue($category->isActive);
    }

    public function testDeactivated()
    {
        $category = new Category(
            id: Uuid::uuid4()->toString(),
            name: "New Cat",
            isActive: true,
        );

        $this->assertTrue($category->isActive);
        $category->deactivate();
        $this->assertFalse($category->isActive);
    }

    public function testUpdate()
    {
        $uuid = Uuid::uuid4()->toString();

        $category = new Category(
            id: $uuid,
            name: "New Cat",
            description: "New Cat Description",
            isActive: true,
        );

        $category->update(
            name: "new_name",
            description: "new_description",
        );

        $this->assertEquals('new_name', $category->name);
        $this->assertEquals('new_description', $category->description);
    }

    public function testExceptionName()
    {
        try {
            $category = new Category(
                id: Uuid::uuid4()->toString(),
                name: "N",
                description: 'New Cat Description',
                isActive: true,
            );
            $this->assertTrue(false);
        } catch (\Throwable $e) {
            $this->assertInstanceOf(EntityValidationException::class, $e);
        }
    }

    public function testExceptionDescription()
    {
        try {
            new Category(
                id: Uuid::uuid4()->toString(),
                name: "N",
                description: random_bytes(99999),
                isActive: true,
            );
            $this->assertTrue(false);
        } catch (\Throwable $e) {
            $this->assertInstanceOf(EntityValidationException::class, $e);
        }
    }
}
