<?php
namespace App\Domain\Account\User;

use DateTime;
use LogicException;
use InvalidArgumentException;
use App\Domain\Account\User\Email;
use App\Domain\Validations\IValidable;
use App\Domain\Validations\ValidationResult;
use App\Domain\Account\User\PlainTextPassword;
use App\Domain\Account\User\Documents\IDocument;
use App\Domain\Account\User\ValidationRules\UserValidation;

class User implements IValidable {

    private Address $address;

    public function __construct(
        public readonly string $id, 
        private string $firstName,
        private string $lastName,
        private IDocument $document,
        private UserValidation $userValidation,
        private PlainTextPassword $password, 
        private DateTime $birthDate,
        private Email $email 
    )
    {}
    
    public function homeAddress(): Address
    {
        return $this->address;
    }

    public function changeHomeAddress(Address $address): void
    {
        $this->address = $address;
    }

    public function changeDocument(IDocument $document): void
    {
        $this->document = $document;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function verifyEmail($newCode): bool
    {
        if(is_null($newCode))
            throw new InvalidArgumentException('Erro ao verificar o e-mail, não foi fornecido código de verificação.');

        if(is_null($this->email->lastGeneratedCode()))
            throw new LogicException('Erro ao verificar o e-mail, primeiro é necessário ter o ultímo código gerado para que seja possível realizar a comparação.');

        return $this->email->verify($newCode);
    }

    public function password(): string | PlainTextPassword
    {
        return $this->password;
    }

    public function changePassword(PlainTextPassword $password): void
    {
        $this->password = $password->password();
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function birthDate(): string
    {
        return $this->birthDate->format('Y-m-d');
    }

    public function document(): IDocument 
    {
        return $this->document;
    }

    public function fullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function validate(UserValidation $userValidation): ValidationResult
    {
        return $this->email->validate();

    }
}