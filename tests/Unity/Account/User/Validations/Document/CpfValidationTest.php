<?php

use App\Infra\SymfonyValidator;
use PHPUnit\Framework\TestCase;
use App\Infra\SymfonyValidationConstraints;
use App\Domain\Account\Documents\ValidationRules\CpfValidaton;
use App\Domain\Account\Documents\ValidationRules\DocumentValidator;

class CpfValidationTest extends TestCase
{
    private DocumentValidator $documentValidator;

    public function setUp(): void
    {
        $constraints = new SymfonyValidationConstraints();
        $validator = new SymfonyValidator();
        $validationsForCpf = new CpfValidaton($constraints);
        $this->documentValidator = new DocumentValidator('CPF', $constraints, $validator, $validationsForCpf);
        parent::setUp();
    }

    public function testIfCpfWithLettersReturnsValidationError()
    {
        $cpf = '123.456.789-AB';
        $result = $this->documentValidator->validate('CPF', $cpf);

        $this->assertTrue($result->hasErrors());
        $this->assertContains('Deve conter apenas números.', $result->errors()['Documento']);
    }    

    public function testIfCpfHasSizeDifferentFrom11DigitsReturnsValidationError()
    {
        $cpf = '1123.456.789-12';
        $result = $this->documentValidator->validate('CPF', $cpf);

        $this->assertTrue($result->hasErrors());
        $this->assertContains('Deve conter 11 caracteres.', $result->errors()['Documento']);
    }

    public function testIfValidatingACpfWithAllEqualNumbersReturnsError()
    {
        $cpf = '111.111.111-11';
        $result = $this->documentValidator->validate('CPF', $cpf);
        $this->assertTrue($result->hasErrors());
        $this->assertContains('Não pode conter todos os números iguais.', $result->errors()['Documento']);
    }

    public function testIfValidatingCpfWithOnlyInvalidDigitsReturnsError()
    {
        $cpf = "496.018.570-86";
        $result = $this->documentValidator->validate('CPF', $cpf);
        $this->assertTrue($result->hasErrors());
        $this->assertContains('Digitos inválidos.', $result->errors()['Documento']);
    }

    public function testIfCreatingAValidCpfDoesNotReturnError()
    {
        $cpf = "496.018.570-87";
        $result = $this->documentValidator->validate('CPF', $cpf);
        $this->assertFalse($result->hasErrors());
    }

}

