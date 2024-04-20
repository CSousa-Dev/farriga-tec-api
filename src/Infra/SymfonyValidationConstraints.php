<?php 
namespace App\Infra;
use App\Domain\Validations\IConstraints;
use Symfony\Component\Validator\Constraints as Assert;

class SymfonyValidationConstraints implements IConstraints
{
    public function email()
    {
        return new Assert\Email();
    }

    public function notNull()
    {
        return new Assert\NotNull();
    }

    public function notBlanck()
    {
        return new Assert\NotBlank();
    }

    public function isDate()
    {
        return new Assert\Date();
    }

    public function callback(callable $callback)
    {
        return new Assert\Callback(
            callback: $callback
        );
    }

    public function length(int|null $min = null, int|null $max = null, string|null $minMessage = null, string|null $maxMessage = null)
    {
        return new Assert\Length(
            min: $min,
            max: $max
        );
    }

    public function greaterThan($value)
    {
        return new Assert\GreaterThan(
            value: $value
        );
    }

    public function greaterThanOrEqual($value)
    {
        return new Assert\GreaterThanOrEqual(
            value: $value
        );
    }

    public function lessThanOrEqual($value)
    {
        return new Assert\LessThanOrEqual(
            value: $value
        );
    }

    public function range($min, $max)
    {
        return new Assert\Range(
            min: $min,
            max: $max
        );
    }

    public function regex($pattern, $match = true)
    {
        return new Assert\Regex(
            pattern: $pattern,
            match: $match,
        );
    }
}

            