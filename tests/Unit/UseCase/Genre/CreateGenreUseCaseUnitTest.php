<?php

namespace Tests\Unit\UseCase\Genre;

use PHPUnit\Framework\TestCase;

class CreateGenreUseCaseUnitTest extends TestCase
{
    public function test_create(): void
    {
        $usecase = new CreateGenreUseCase();
    }
}
