<?php 
namespace App\Domain\Account\Documents;

use App\Domain\Validations\ValidationResult;
use App\Domain\Account\User\Documents\IDocument;
use App\Domain\Account\Documents\ValidationRules\DocumentValidator;

class Cpf implements IDocument
{
    private readonly string $type;
    private readonly string $country;

    public function __construct(private DocumentValidator $documentValidator, private readonly string $number)
    {
        $this->type = 'CPF';
        $this->country = 'br';
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

    public function validate(): ValidationResult
    {
        return $this->documentValidator->validate($this->type, $this->number);
    }   
}