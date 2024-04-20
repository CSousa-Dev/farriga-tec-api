<?php 
namespace App\Domain\Account\Documents;

use App\Domain\Validations\ValidationList;
use App\Domain\Validations\ValidationMaker;
use App\Domain\Validations\ValidationResult;
use App\Domain\Account\Documents\IDocumentValidator;

class DocumentValidation extends ValidationMaker
{
    public function __construct(private IDocumentValidator $documentValidator)
    {}

    public function validateDocument(...$documentData): ValidationResult
    {
        return $this->documentValidator->validate($documentData);
    }

    public function allRules(): ValidationList
    {
        return $this->documentValidator->allRules();
    }
}