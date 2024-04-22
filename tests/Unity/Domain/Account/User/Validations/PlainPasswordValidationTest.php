<?php
namespace App\Tests\Unity\Domain\Account\User\Validations;

use App\Infra\SymfonyValidator;
use PHPUnit\Framework\TestCase;
use App\Infra\SymfonyValidationConstraints;
use App\Domain\Account\User\ValidationRules\PlainTextPasswordValidation;

class PlainPasswordValidationTest extends TestCase
{
    private SymfonyValidator $validator;
    private PlainTextPasswordValidation $passwordValidation;
    private SymfonyValidationConstraints $constraints;
    protected function setUp(): void
    {
        $this->validator = new SymfonyValidator();
        $this->constraints = new SymfonyValidationConstraints();
        $this->passwordValidation = new PlainTextPasswordValidation($this->constraints, $this->validator);
        parent::setUp();
    }

    public function testPasswordRules()
    {
        $invalidPassword1 = '1234567';
        $validationResult = $this->passwordValidation->validatePassword($invalidPassword1);
        $resultsForInvalidPassword1 = $validationResult->errors();

        $passwordConsecutiveNumbers = '111111111';
        $validationResult = $this->passwordValidation->validatePassword($passwordConsecutiveNumbers);

        $resultsForPasswordConsecutiveNumbers = $validationResult->errors();

        $firstName = 'John';
        $lastName = 'Doe';
        $birthDate = new \DateTime('1990-01-01');
        $passwordWithNameAndBirthdate = 'JohnDoe19900101';

        $validationResult = $this->passwordValidation->validatePassword($passwordWithNameAndBirthdate, $firstName, $lastName, $birthDate);

        $resultsForPasswordWithNameAndBirthdate = $validationResult->errors();

        $passwordWithNoNumbers = 'Test@test';
        $validationResult = $this->passwordValidation->validatePassword($passwordWithNoNumbers);
        $resultsForPasswordWithNoNumbers = $validationResult->errors();


        $this->assertNotEmpty($resultsForInvalidPassword1);
        $this->assertContains('Deve conter pelo menos um caractere especial. Ex: !@#$%^&*().', $resultsForInvalidPassword1['Senha'], 'Must contain at least one special character. Ex: !@#$%^&*().');
        $this->assertContains('Deve conter pelo menos uma letra minúscula.', $resultsForInvalidPassword1['Senha'], 'Must contain at least one lowercase letter.');
        $this->assertContains('Não pode conter sequências óbvias de números ou letras. Sequencia(s) encontrada(s): 123, 234, 345, 456, 567', $resultsForInvalidPassword1['Senha'], 'Cannot contain obvious sequences of numbers or letters. Sequences like: 123, abc, cba, 321');
        $this->assertContains('Deve conter pelo menos uma letra maiúscula.', $resultsForInvalidPassword1['Senha'], 'Must contain at least one uppercase letter.');
        $this->assertContains('A senha deve conter no mínimo 8 caracteres.', $resultsForInvalidPassword1['Senha'], 'The password must contain at least 8 characters.');

        $this->assertNotEmpty($resultsForPasswordConsecutiveNumbers);
        $this->assertContains('Não pode conter mais de dois caracteres iguais consecutivos.', $resultsForPasswordConsecutiveNumbers['Senha'], 'Cannot contain more than two consecutive identical characters.');

        $this->assertNotEmpty($resultsForPasswordWithNameAndBirthdate);
        $this->assertContains('Não pode conter sua data de nascimento.', $resultsForPasswordWithNameAndBirthdate['Senha'], 'The password cannot contain the user\'s birth date.');
        $this->assertContains('Não pode conter seu nome.', $resultsForPasswordWithNameAndBirthdate['Senha'], 'The password cannot contain the user\'s name.');
        $this->assertContains('Não pode conter seu sobrenome.', $resultsForPasswordWithNameAndBirthdate['Senha'], 'The password cannot contain the user\'s last name.');

        $this->assertNotEmpty($resultsForPasswordWithNoNumbers);
        $this->assertContains('Deve conter pelo menos um número.', $resultsForPasswordWithNoNumbers['Senha'], 'Must contain at least one number.');
    }

    public function testPasswordRulesWithValidPassword()
    {
        $validPassword = 'Test@2024';
        $validationResult = $this->passwordValidation->validatePassword($validPassword);
        $resultsForValidPassword = $validationResult->errors();

        $this->assertEmpty($resultsForValidPassword);
    }
}