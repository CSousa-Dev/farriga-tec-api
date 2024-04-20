<?php 
namespace App\Domain\Account\Documents;

use App\Domain\ValidationList;
use App\Domain\Account\Documents\IDocument;
use App\Domain\Account\ValidationsRules\IDocumentValidationRules;
use App\Domain\IValidationRules;

class Cpf implements IDocument
{
    private string $number;
    private string $type = 'CPF';
    private string $country = 'BR';

    public function __construct($number)
    {
        $this->number = $number;
    }
    
    public function number(): string
    {
        return $this->number;
    }

    public function country(): string
    {
        return $this->country;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function validationRules(IValidationRules $validationRules): ValidationList 
    {
        return $validationRules->allRules();
    }
}