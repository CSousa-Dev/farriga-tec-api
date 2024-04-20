<?php 
namespace App\Domain\Validations;

use App\Domain\ValidationList;

interface IValidationRules
{
    public function allRules(): ValidationList;
}