<?php
namespace App\Domain\Account\Documents\ValidationRules;

use App\Domain\Account\Documents\ValidationRules\ValidationsForDocuments;
use App\Domain\Validations\Validator;
use App\Domain\Validations\IConstraints;
use App\Domain\Validations\ValidationList;
use App\Domain\Validations\ValidationRule;
use App\Domain\Validations\ValidationMaker;
use App\Domain\Validations\ValidationResult;

class DocumentValidation extends ValidationMaker
{

    /**
     * @var ValidationsForDocuments[]
     */
    private $validationsForDocuments;

    /**
     *
     * @var ?ValidationRule[]
     */
    private $validationRules = null;

    /**
     *
     * @var ValidationsForDocuments
     */
    private ?ValidationsForDocuments $matchValidationForDocument = null;

    public function __construct(private string $documentType, private IConstraints $constraints, private Validator $validator, ValidationsForDocuments ...$validationsForDocuments)
    {
        $this->validationsForDocuments = $validationsForDocuments;
    }

    public function validate($documentType, $options): ValidationResult
    {
        $this->getValidationType($documentType);

        if($this->matchValidationForDocument === null) 
            throw new \InvalidArgumentException("Document type not found.");
        

        return $this->validator->validate(
            $this->foreachRuleSetValue(
                $this->matchValidationForDocument->optionsToValue($options), 
                ...$this->matchValidationForDocument->rules()
            )
        );
    }

    public function changeDocumentType($documentType) {
        $this->documentType = $documentType;
        $this->getValidationType($documentType);
    }

    private function getValidationType($documentType) {
        foreach($this->validationsForDocuments as $validationForDocument) {
            if($validationForDocument->typeMatchesMyValidationType($documentType)) {
                $this->matchValidationForDocument = $validationForDocument; 
                break;
            }
        }
    }

    public function allRules(): ValidationList
    {
        $this->getValidationType($this->documentType);

        if($this->matchValidationForDocument === null) 
            throw new \InvalidArgumentException("Document type not found.");

        return new ValidationList(...$this->matchValidationForDocument->rules());
    }


}