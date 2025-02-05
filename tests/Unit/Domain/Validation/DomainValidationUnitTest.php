<?php

namespace Tests\Unit\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use PHPUnit\Framework\TestCase;

class DomainValidationUnitTest extends TestCase
{
    public function testNotNull()
    {
        try {
            $value = "value";
            DomainValidation::notNull($value);
            $this->assertTrue(true);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testNotNullCustomMessageException()
    {
        try {
            $value = '';
            DomainValidation::notNull($value, "Custom message exception");
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, "Custom message exception");
        }
    }

    public function testStrMaxLength()
    {
        try {
            $value = "value";
            DomainValidation::strMaxLength($value, 5);
            $this->assertTrue(true);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testStrMinLength()
    {
        try {
            $value = "value";
            DomainValidation::strMinLength($value, 12);
            $this->assertTrue(true);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }
}
