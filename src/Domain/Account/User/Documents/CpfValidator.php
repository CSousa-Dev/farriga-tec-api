<?php 
namespace App\Domain\Account\Documents;
use App\Domain\Validations\ValidationList;
use App\Domain\Account\Documents\IDocumentValidator;

class CpfValidator implements IDocumentValidator
{
    public function validate(...$values): bool
    {
        return true;
    }

    public function allRules(): ValidationList
    {
        return new ValidationList();
    }
}