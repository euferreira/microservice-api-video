<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\MethodsMagicsTrait;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use Core\Domain\ValueObject\Uuid;

class Category
{
    use MethodsMagicsTrait;

    public function __construct(
        protected Uuid|string      $id = '',
        protected string           $name = '',
        protected string           $description = '',
        protected bool             $isActive = true,
        protected \DateTime|string $createdAt = '',
    )
    {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->createdAt = $this->createdAt ? new \DateTime($this->createdAt) : new \DateTime();
        $this->validate();
    }

    public function activate(): void
    {
        $this->isActive = true;
    }

    public function deactivate(): void
    {
        $this->isActive = false;
    }

    public function update(
        string $name = '',
        string $description = '',
        bool   $isActive = true,
    ): void
    {
        $this->name = $name;
        $this->description = $description;
        $this->isActive = $isActive;
        $this->validate();
    }

    /**
     * @throws EntityValidationException
     */
    private function validate(): void
    {
        DomainValidation::notNull($this->name, "Name is required");
        DomainValidation::strMinLength($this->name, 2, "Name must be greater than 2 characters");
    }
}
