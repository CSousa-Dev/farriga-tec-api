<?php

namespace Tests\Unit\Domain\Account\Services;

use PHPUnit\Framework\TestCase;
use App\Domain\Account\User\User;
use App\Domain\Account\User\Email;
use App\Domain\Account\User\PasswordHasher;
use App\Domain\Validations\ValidationResult;
use App\Domain\Account\Repository\UserRepository;
use App\Domain\Account\Services\RegisterUser\RegisterUser;
use App\Domain\Account\User\ValidationRules\EmailValidation;
use App\Domain\Account\Services\RegisterUser\UserEmailAlreadyRegisteredException;
use App\Domain\Account\Services\RegisterUser\UserDocumentAlreadyRegisteredException;
use App\Domain\Account\Services\RegisterUser\RegisterUserViolateValidationConstraintException;
use App\Domain\Account\User\IPasswordHasher;
use App\Domain\Account\User\PlainTextPassword;
use App\Service\SymfonyPasswordHasher;

class RegisterUserTest extends TestCase
{
    private $userRepositoryMock;
    private $plainTextPassword;
    private $userMock;
    private $registerUser;

    private $emailMock;

    private $passwordHasherMock;

    protected function setUp(): void
    {
        $this->userRepositoryMock = $this->createMock(UserRepository::class);
        $this->plainTextPassword = $this->createMock(PlainTextPassword::class);
        $this->plainTextPassword
            ->method('password')
            ->willReturn('plain_password');

        $this->userMock = $this->createMock(User::class);
        $this->emailMock = $this->getMockBuilder(Email::class)
                     ->setConstructorArgs(['test@test.com', $this->createMock(EmailValidation::class)])
                     ->getMock();

        $this->passwordHasherMock = $this->createMock(SymfonyPasswordHasher::class);
        $this->passwordHasherMock
            ->method('hash')
            ->willReturn('hashed_password');
          

        $this->userMock->expects($this->any())
            ->method('email')
            ->willReturn($this->emailMock);
    

        $this->registerUser = new RegisterUser(
            $this->userRepositoryMock,
            $this->passwordHasherMock
        );
    }

    public function testSuccessfulRegistration()
    {
        $passValidationResultMock = $this->createMock(
            ValidationResult::class
        );
        
        $passValidationResultMock->expects($this->once())
            ->method('hasErrors')
            ->willReturn(false);

        $this->userMock->expects($this->once())
            ->method('validate')
            ->willReturn($passValidationResultMock);

        $this->userRepositoryMock->expects($this->once())
            ->method('isEmailAlreadyRegistered')
            ->willReturn(false);

        $this->userRepositoryMock->expects($this->once())
            ->method('isDocumentAlreadyRegistered')
            ->willReturn(false);
        
        $this->plainTextPassword->expects($this->once())
            ->method('validate')
            ->willReturn($this->createMock(ValidationResult::class));

        $this->userRepositoryMock->expects($this->once())
            ->method('registerNewUser');

        $this->registerUser->execute($this->plainTextPassword, $this->userMock);
    }

    public function testValidationFailure()
    {
        $this->expectException(RegisterUserViolateValidationConstraintException::class);
        $failureValidationResultMock = $this->createMock(
            ValidationResult::class
        );
        
        $failureValidationResultMock->expects($this->once())
            ->method('hasErrors')
            ->willReturn(true);

        $this->userMock->expects($this->once())
            ->method('validate')
            ->willReturn($failureValidationResultMock);

        $this->registerUser->execute($this->plainTextPassword, $this->userMock);
    }

    public function testUserEmailAlreadyRegistered()
    {
        $this->expectException(UserEmailAlreadyRegisteredException::class);
        $passValidationResultMock = $this->createMock(
            ValidationResult::class
        );
        
        $passValidationResultMock->expects($this->once())
            ->method('hasErrors')
            ->willReturn(false);

        $this->userMock->expects($this->once())
            ->method('validate')
            ->willReturn($passValidationResultMock);

        $this->userRepositoryMock->expects($this->once())
            ->method('isEmailAlreadyRegistered')
            ->willReturn(true);

        $this->registerUser->execute($this->plainTextPassword, $this->userMock);
    }

    public function testUserDocumentAlreadyRegistered()
    {
        $this->expectException(UserDocumentAlreadyRegisteredException::class);
        
        $passValidationResultMock = $this->createMock(
            ValidationResult::class
        );
        
        $passValidationResultMock->expects($this->once())
            ->method('hasErrors')
            ->willReturn(false);

        $this->userMock->expects($this->once())
            ->method('validate')
            ->willReturn($passValidationResultMock);

        $this->userRepositoryMock->expects($this->once())
            ->method('isEmailAlreadyRegistered')
            ->willReturn(false);

        $this->userRepositoryMock->expects($this->once())
            ->method('isDocumentAlreadyRegistered')
            ->willReturn(true);

        $this->registerUser->execute($this->plainTextPassword, $this->userMock);
    }
}
