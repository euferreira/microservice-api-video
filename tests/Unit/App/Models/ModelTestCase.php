<?php

namespace Tests\Unit\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;

abstract class ModelTestCase extends TestCase
{
    abstract protected function model(): Model;

    abstract protected function traits(): array;

    abstract protected function fillable(): array;

    abstract protected function casts(): array;

    public function testIfUseTraits(): void
    {
        $traitsNeed = $this->traits();
        $traitsUsed = array_keys(class_uses($this->model()));

        $this->assertEquals($traitsNeed, $traitsUsed);
    }

    public function testFillables()
    {
        $fillableNeed = $this->fillable();

        $fillable = $this->model()->getFillable();
        $this->assertEqualsCanonicalizing($fillableNeed, $fillable);
    }

    public function testIncrementingIsFalse()
    {
        $model = $this->model();
        $this->assertFalse($model->incrementing);
    }

    public function testHasCasts()
    {
        $castNeed = $this->casts();

        $casts = $this->model()->getCasts();
        $this->assertEqualsCanonicalizing($castNeed, $casts);
    }
}
