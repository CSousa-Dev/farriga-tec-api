<?php
namespace App\Tests\Unity\Account\User\Validations;

use App\Infra\SymfonyValidator;
use PHPUnit\Framework\TestCase;
use App\Infra\SymfonyValidationConstraints;
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
        $this->assertContains('Nome', array_keys($validationResult->errors()));
        $this->assertContains('É obrigatório.', $validationResult->errors()['Nome']);
    }

    public function testLastNameIsNotEmpty()
    {
        $lastName    = null;
        $validationResult = $this->userValidation->validateLastName($lastName);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('Sobrenome', array_keys($validationResult->errors()));
        $this->assertContains('É obrigatório.', $validationResult->errors()['Sobrenome']);
    }

    public function testFirstNameMustContainAMinimumOfThreeCharacters()
    {
        $firstName    = 'aa';
        $validationResult = $this->userValidation->validateFirstName($firstName);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('Nome', array_keys($validationResult->errors()));
        $this->assertContains('Deve ter no mínimo 3 caracteres.', $validationResult->errors()['Nome']);
    }

    public function testLastNameMustContainAMinimumOfThreeCharacters()
    {
        $lastName    = 'aa';
        $validationResult = $this->userValidation->validateLastName($lastName);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('Sobrenome', array_keys($validationResult->errors()));
        $this->assertContains('Deve ter no mínimo 3 caracteres.', $validationResult->errors()['Sobrenome']);
    }

    public function testFirstNameMustContainAMaximumOfTenCharacters()
    {
        $firstName    = 'aaaaaaaaaaa';
        $validationResult = $this->userValidation->validateFirstName($firstName);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('Nome', array_keys($validationResult->errors()));
        $this->assertContains('Deve ter no máximo 10 caracteres.', $validationResult->errors()['Nome']);
    }

    public function testLastNameMustContainAMaximumOfTenCharacters()
    {
        $lastName    = 'aaaaaaaaaaa';
        $validationResult = $this->userValidation->validateLastName($lastName);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('Sobrenome', array_keys($validationResult->errors()));
        $this->assertContains('Deve ter no máximo 10 caracteres.', $validationResult->errors()['Sobrenome']);
    }
}