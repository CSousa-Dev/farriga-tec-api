<?php
namespace App\Tests\Unity\Domain\Account\User\Validations;

use App\Service\Validation\SymfonyValidator;
use PHPUnit\Framework\TestCase;
use App\Service\Validation\SymfonyValidationConstraints;
use App\Domain\Account\User\ValidationRules\UserValidation;

class UserNameValidationTest extends TestCase
{
    private UserValidation $userValidation;
    public function setUp(): void
    {
        $symfonyValidator = new SymfonyValidator();
        $this->userValidation = new UserValidation($symfonyValidator, new SymfonyValidationConstraints());
        parent::setUp();
    }
    
    public function testFirstNameIsNotEmpty()
    {
        $userFirstName    = null;
        $validationResult = $this->userValidation->validateFirstName($userFirstName);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('firstName', array_keys($validationResult->errors()));
        $this->assertContains('É obrigatório.', $validationResult->errors()['firstName']);
    }

    public function testLastNameIsNotEmpty()
    {
        $lastName    = null;
        $validationResult = $this->userValidation->validateLastName($lastName);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('lastName', array_keys($validationResult->errors()));
        $this->assertContains('É obrigatório.', $validationResult->errors()['lastName']);
    }

    public function testFirstNameMustContainAMinimumOfThreeCharacters()
    {
        $firstName    = 'aa';
        $validationResult = $this->userValidation->validateFirstName($firstName);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('firstName', array_keys($validationResult->errors()));
        $this->assertContains('Deve ter no mínimo 3 caracteres.', $validationResult->errors()['firstName']);
    }

    public function testLastNameMustContainAMinimumOfThreeCharacters()
    {
        $lastName    = 'aa';
        $validationResult = $this->userValidation->validateLastName($lastName);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('lastName', array_keys($validationResult->errors()));
        $this->assertContains('Deve ter no mínimo 3 caracteres.', $validationResult->errors()['lastName']);
    }

    public function testFirstNameMustContainAMaximumOfTenCharacters()
    {
        $firstName    = 'aaaaaaaaaaa';
        $validationResult = $this->userValidation->validateFirstName($firstName);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('firstName', array_keys($validationResult->errors()));
        $this->assertContains('Deve ter no máximo 10 caracteres.', $validationResult->errors()['firstName']);
    }

    public function testLastNameMustContainAMaximumOfTenCharacters()
    {
        $lastName    = 'aaaaaaaaaaa';
        $validationResult = $this->userValidation->validateLastName($lastName);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('lastName', array_keys($validationResult->errors()));
        $this->assertContains('Deve ter no máximo 10 caracteres.', $validationResult->errors()['lastName']);
    }
}