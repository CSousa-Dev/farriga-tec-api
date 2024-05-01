<?php
namespace App\Tests\Unity\Domain\Account\User\Validations;

use DateTime;
use App\Service\Validation\SymfonyValidator;
use PHPUnit\Framework\TestCase;
use App\Service\Validation\SymfonyValidationConstraints;
use App\Domain\Account\User\ValidationRules\UserValidation;

class UserBirthDateValidationTest extends TestCase
{
    private UserValidation $userValidation;
    public function setUp(): void
    {
        $symfonyValidator = new SymfonyValidator();
        $this->userValidation = new UserValidation($symfonyValidator, new SymfonyValidationConstraints());
        parent::setUp();
    }
    
    public function testBirthDateMustNotBeNull()
    {
        $birthDate    = null;
        $validationResult = $this->userValidation->validateBirthDateYmd($birthDate);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('birthDate', array_keys($validationResult->errors()));
        $this->assertContains('É obrigatório.', $validationResult->errors()['birthDate']);
    }

    public function testBirthDateMustBeAValidDate()
    {
        $birthDate    =  'a25/12/1990';
        $validationResult = $this->userValidation->validateBirthDateYmd($birthDate);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('birthDate', array_keys($validationResult->errors()));
        $this->assertContains('Deve ser uma data em formato válido.', $validationResult->errors()['birthDate']);
    }

    public function testMinAgeIs12Years()
    {
        $birthDate    = new DateTime('now');
        $validationResult = $this->userValidation->validateBirthDateYmd($birthDate->format('Y-m-d'));
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('birthDate', array_keys($validationResult->errors()));
        $this->assertContains('A idade mínima para criar uma conta é de 12 anos. Crie uma conta com a ajuda de um responsável.', $validationResult->errors()['birthDate']);
    }

    public function testValidDate()
    {
        $birthDate    = new DateTime('now');
        $birthDate->modify('-14 years');
        $validationResult = $this->userValidation->validateBirthDateYmd($birthDate->format('Y-m-d'));
        $this->assertFalse($validationResult->hasErrors());
    }

}