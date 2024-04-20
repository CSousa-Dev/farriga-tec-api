<?php 
namespace App\Domain\Validations;

interface IConstraints
{
    public function email();
    public function regex(string | array | null $pattern, bool | null $match = true);
    public function range($min, $max);

    public function length(?int $min = null, ?int $max = null);

    public function notNull();
    public function notBlanck();

    public function callback(callable $callback);

    public function isDate();

    public function greaterThanOrEqual($value);
    public function greaterThan($value);
    public function lessThanOrEqual($value);
}