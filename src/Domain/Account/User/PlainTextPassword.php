<?php
namespace App\Domain\Account\User;

use DateTime;
use App\Domain\Validations\IValidable;
use App\Domain\Validations\ValidationResult;
use App\Domain\Account\User\PlainTextPasswordValidation;

class PlainTextPassword implements IValidable
{
    private ?string $ownerFirstName = null;
    private ?string $ownerLastName = null;
    private ?DateTime $ownerBirthDate = null;

    public function __construct(
        public readonly string $password,
        private PlainTextPasswordValidation $plainTextValidationRules)
    {
    }

    public function setOwnerData(
        string $ownerFirstName,
        string $ownerLastName,
        DateTime $ownerBirthDate
    )
    {
        $this->ownerFirstName = $ownerFirstName;
        $this->ownerLastName  = $ownerLastName;
        $this->ownerBirthDate = $ownerBirthDate;
    }

    public function validate(): ValidationResult
    {
        return $this->plainTextValidationRules->validatePassword($this->password, $this->ownerFirstName, $this->ownerLastName, $this->ownerBirthDate);
    }
}