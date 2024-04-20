<?php
namespace App\Domain\Account\User;

use DateTime;
use App\Domain\Validations\Validator;
use App\Domain\Validations\IConstraints;
use App\Domain\Validations\ValidationList;
use App\Domain\Validations\ValidationRule;
use App\Domain\Validations\ValidationMaker;
use App\Domain\Validations\ValidationResult;

class PlainTextPasswordValidation extends ValidationMaker
{
    private IConstraints $constraints;
    private Validator $validator;

    public function __construct(IConstraints $constraints, Validator $validator)
    {
        $this->constraints = $constraints;
        $this->validator = $validator;
    }

    public function validatePassword(string $password, $firstName = null, $lastName = null, DateTime $birthDate = new DateTime('now')): ValidationResult
    {
        return $this->validator->validate($this->foreachRuleSetValue($password, ...$this->passwordSecurityRules($firstName, $lastName, $birthDate)));
    }

    private function passwordSecurityRules($firstName = null, $lastName = null, DateTime $birthDate = new DateTime()): array
    {
        $especialChar = new ValidationRule(
            validationRule: $this->constraints->callback(
                function ($password) {
                    return !self::hasSafeSpecialCharacter($password);
                }
            ),
            field: 'Senha',
            message: 'Deve conter pelo menos um caractere especial. Ex: !@#$%^&*().'
        );

        $lowerCase = new ValidationRule(
            validationRule: $this->constraints->callback(
                function ($password) {
                    return !self::hasLowerCaseLetter($password); 
                }
            ),
            field: 'Senha',
            message: 'Deve conter pelo menos uma letra minúscula.'
        );

        $insecureChar = new ValidationRule(
            validationRule: $this->constraints->callback(
                function ($password) {
                    return self::hasInsecureCharacter($password);
                }
            ),
            field: 'Senha',
            message: 'Não pode conter caracteres especiais como: " \' \ / < > | ` ~'
        );

        $sequential = new ValidationRule(
            validationRule: $this->constraints->callback(
                function ($password) {
                    return !self::noSequentialNumbersOrLetters($password);
                }
            ),
            field: 'Senha',
            message: 'Não pode conter sequências de números ou letras.'
        );

        $consecutive = new ValidationRule(
            validationRule: $this->constraints->callback(
                function ($password) {
                    return !self::noMoreThanTwoConsecutiveCharacters($password);
                }
            ),
            field: 'Senha',
            message: 'Não pode conter mais de dois caracteres iguais consecutivos.'
        );

        $upperCase = new ValidationRule(
            validationRule: $this->constraints->callback(
                function ($password) {
                    return !self::hasUpperCaseLetter($password);
                }
            ),
            field: 'Senha',
            message: 'Deve conter pelo menos uma letra maiúscula.'
        );

        $minEightChars = new ValidationRule(
            validationRule: $this->constraints->length(
                min: 8,
            ),
            field: 'Senha',
            message: 'A senha deve conter no mínimo 8 caracteres.'
        );

        $mustNotContainBirthdate = new ValidationRule(
            validationRule: $this->constraints->callback(
                function ($password) use ($birthDate) {
                    return self::checkPasswordContainADate($password, $birthDate);
                }
            ),
            field: 'Senha',
            message: 'Não pode conter sua data de nascimento.'
        );

        $mustNotContainFirstName = new ValidationRule(
            validationRule: $this->constraints->callback(
                function ($password) use ($firstName) {
                    return stripos(strtoupper($password), strtoupper($firstName)) !== false;
                }
            ),
            field: 'Senha',
            message: 'Não pode conter o seu nome na senha.'
        );

        $mustNotContainLastName = new ValidationRule(
            validationRule: $this->constraints->callback(
                function ($password) use ($lastName) {
                    return stripos(strtoupper($password), strtoupper($lastName)) !== false;
                }
            ),
            field: 'Senha',
            message: 'Não pode conter o seu sobrenome na senha.'
        );

        return [
            $especialChar,
            $lowerCase,
            $insecureChar,
            $sequential,
            $consecutive,
            $upperCase,
            $minEightChars,
            $mustNotContainBirthdate,
            $mustNotContainFirstName,
            $mustNotContainLastName
        ];
        
    }

    private static function hasSafeSpecialCharacter($password) {
        // Lista de caracteres considerados seguros
        $safeCharacters = ['!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '_', '=', '+', '{', '}', ';', ':', ',','.'];
        
        foreach ($safeCharacters as $char) {
            if (strpos($password, $char) !== false) {
                return true;
            }
        }
        
        return false;
    }
      
    private static function hasLowerCaseLetter($password) {
        return preg_match('/[a-z]/', $password);
    }

    private static function hasInsecureCharacter($password) 
    {
        $insecureCharacters = ['"', "'", '\\', '/', '<', '>', '|', '`', '~'];
        
        foreach ($insecureCharacters as $char) {
            if (strpos($password, $char) !== false) {
                return true;
            }
        }
        
        return false;
    }

    private static function noSequentialNumbersOrLetters($password) {
        return !preg_match('/(\d{4,})|([a-zA-Z]{4,})/', $password);
    }
        
    private static function noMoreThanTwoConsecutiveCharacters($password) {
        return !preg_match('/(.)\1\1/', $password);
    }

    private static function hasUpperCaseLetter($password) {
        return preg_match('/[A-Z]/', $password);
    }
    
    private static function checkPasswordContainADate($password, DateTime $date)
    {
        $dateYmd = $date->format('Ymd');
        $dateDmY = $date->format('dmY');
        
        $regexYmd = "/$dateYmd/";
        $regexDmY = "/$dateDmY/";

        
        if (preg_match($regexYmd, $password) || preg_match($regexDmY, $password)) {
            return true; 
        }
        
        return false; 
    }

    public function allRules(): ValidationList
    {
        return new ValidationList(...$this->passwordSecurityRules());
    }
}