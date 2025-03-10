<?php

namespace Core\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;

class DomainValidation
{
    public static function notNull(string $value, ?string $exceptMessage = null)
    {
        if (empty($value)) {
            throw new EntityValidationException($exceptMessage ?? "Value cannot be null");
        }
    }

    public static function strMaxLength(string $value, int $maxLength = 255, ?string $exceptMessage = null)
    {
        if (strlen($value) >= $maxLength) {
            throw new EntityValidationException($exceptMessage ?? "Value cannot be greater than {$maxLength} characters");
        }
    }

    public static function strMinLength(string $value, int $minLength = 1, ?string $exceptMessage = null)
    {
        if (strlen($value) < $minLength)
            throw new EntityValidationException($exceptMessage ?? "Value cannot be less than {$minLength} characters");
    }

    public static function strCanNullAndMaxLength(string $value = '', int $maxLength = 255, ?string $exceptMessage = null)
    {
        if (!empty($value) && strlen($value) > $maxLength)
            throw new EntityValidationException($exceptMessage ?? "Value cannot be greater than {$maxLength} characters");
    }
}
