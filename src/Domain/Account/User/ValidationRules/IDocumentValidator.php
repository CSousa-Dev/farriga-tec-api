<?php
namespace App\Domain\Account\Documents;

use App\Domain\Validations\ValidationList;
use App\Domain\Validations\ValidationResult;

interface IDocumentValidator
{
    public function validate(...$documentData): ValidationResult;
    public function allRules(): ValidationList;
}