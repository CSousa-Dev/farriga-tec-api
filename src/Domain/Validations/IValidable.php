<?php
namespace App\Domain\Validations;

interface IValidable{
    public function validate(): ValidationResult;
}