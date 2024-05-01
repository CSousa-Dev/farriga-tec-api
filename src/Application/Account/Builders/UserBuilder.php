<?php 
namespace App\Application\Account\Builders;

use App\Application\Account\Builders\AddressBuilder;
use App\Domain\Account\User\ValidationRules\UserValidation;
use App\Domain\Account\User\ValidationRules\EmailValidation;
use App\Domain\Account\Documents\ValidationRules\DocumentValidation;
use App\Domain\Account\User\ValidationRules\PlainTextPasswordValidation;

class UserBuilder 
{
    private string $firstName;
    private string $lastName;
    private string $birthDate;
    private string $email;
    private string $plainPassword;
    private string $documentNumber;
    private string $documentType;

    public function __construct(
        private UserValidation $userValidation,
        private DocumentValidation $documentValidation,
        private PlainTextPasswordValidation $plainTextPasswordValidation,
        private EmailValidation $emailValidation,
        private AddressBuilder $addressBuilder
    ){}

    public function withEmail($email): UserBuilder
    {
        $this->email = $email;
        return $this;
    }

    public function withFirstName($firstName): UserBuilder
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function withLastName($lastName): UserBuilder
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function withBirthDate($birthDate): UserBuilder
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function withPlainPassword($plainPassword): UserBuilder
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    public function withDocumentNumber($documentNumber): UserBuilder
    {
        $this->documentNumber = $documentNumber;
        return $this;
    }

    public function withDocumentType($documentType): UserBuilder
    {
        $this->documentType = $documentType;
        return $this;
    }

    public function addressBuilder(): AddressBuilder
    {     
        return $this->addressBuilder;
    }

    // public function fromUserDto(UserDTO $userDTO): UserBuilder
    // {
    //     $this->withEmail($userDTO->email);
    //     $this->withFirstName($userDTO->firstName);
    //     $this->withLastName($userDTO->lastName);
    //     $this->withBirthDate($userDTO->birthDate);
    //     $this->withPlainPassword($userDTO->plainPassword);
    //     $this->withDocumentNumber($userDTO->documentNumber);
    //     $this->withDocumentType($userDTO->documentType);
    //     return $this;
    // }





}