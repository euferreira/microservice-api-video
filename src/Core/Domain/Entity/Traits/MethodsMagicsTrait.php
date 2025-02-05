<?php

namespace Core\Domain\Entity\Traits;

trait MethodsMagicsTrait
{
    public function __get(string $name)
    {
        if (isset($this->{$name})) {
            return $this->{$name};
        }

        $className = get_class($this);

        throw new \Exception("The attribute {$name} does not exist in the class {$className}");
    }

    public function id(): string
    {
        return (string) $this->id;
    }

    public function createdAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }
}
