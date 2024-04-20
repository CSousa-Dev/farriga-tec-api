<?php
namespace App\Tests\Unity\Account\User\Validations;

use App\Infra\SymfonyValidator;
use PHPUnit\Framework\TestCase;
use App\Infra\SymfonyValidationConstraints;
use App\Domain\Account\User\ValidationRules\EmailValidation;

class EmailValidationTest extends TestCase
{
    private EmailValidation $emailValidation;
    public function setUp(): void
    {
        $symfonyValidator = new SymfonyValidator();
        $this->emailValidation = new EmailValidation(new SymfonyValidationConstraints(), $symfonyValidator);
        parent::setUp();
    }

    public function testEmailWithoutDomainIsInvalid()
    {
        $emailAddress = 'test';
        $validationResult = $this->emailValidation->validateEmail($emailAddress);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('Email', array_keys($validationResult->errors()));
        $this->assertContains('Precisa ser um e-mail válido.', $validationResult->errors()['Email']);
    }

    public function testEmailWithoutAtSymbolIsInvalid()
    {
        $emailAddress = 'test.com';
        $validationResult = $this->emailValidation->validateEmail($emailAddress);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('Email', array_keys($validationResult->errors()));
        $this->assertContains('Precisa ser um e-mail válido.', $validationResult->errors()['Email']);
    }

    public function testEmailWithoutDotSomethingIsInvalid()
    {
        $emailAddress = 'test@test';
        $validationResult = $this->emailValidation->validateEmail($emailAddress);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('Email', array_keys($validationResult->errors()));
        $this->assertContains('Precisa ser um e-mail válido.', $validationResult->errors()['Email']);
    }

    public function testEmailWithoutPrefixIsInvalid()
    {
        $emailAddress = '@test.com';
        $validationResult = $this->emailValidation->validateEmail($emailAddress);
        $this->assertTrue($validationResult->hasErrors());
        $this->assertContains('Email', array_keys($validationResult->errors()));
        $this->assertContains('Precisa ser um e-mail válido.', $validationResult->errors()['Email']);
    }

    public function testValidEmail()
    {
        $emailAddress = 'email@email.com'; 
        $validationResult = $this->emailValidation->validateEmail($emailAddress);
        $this->assertFalse($validationResult->hasErrors());
    }
}