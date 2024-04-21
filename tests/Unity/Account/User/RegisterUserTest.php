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

class RegisterUserTest extends TestCase
{
    private $userRepositoryMock;
    private $passwordHasherMock;
    private $userMock;
    private $registerUser;

    private $emailMock;

    protected function setUp(): void
    {
        $this->userRepositoryMock = $this->createMock(UserRepository::class);
        $this->passwordHasherMock = $this->createMock(PasswordHasher::class);
        $this->userMock = $this->createMock(User::class);
        $this->emailMock = $this->getMockBuilder(Email::class)
                     ->setConstructorArgs(['test@test.com', $this->createMock(EmailValidation::class)])
                     ->getMock();

        $this->userMock->expects($this->any())
            ->method('email')
            ->willReturn($this->emailMock);
       

        $this->registerUser = new RegisterUser(
            $this->userMock,
            $this->userRepositoryMock,
            $this->passwordHasherMock
        );
    }

    public function testSuccessfulRegistration()
    {
        $this->userMock->expects($this->once())
            ->method('isValid')
            ->willReturn(true);

        $this->userRepositoryMock->expects($this->once())
            ->method('isEmailAlreadyRegistered')
            ->willReturn(false);

        $this->userRepositoryMock->expects($this->once())
            ->method('isDocumentAlreadyRegistered')
            ->willReturn(false);

        $this->passwordHasherMock->expects($this->once())
            ->method('hash')
            ->willReturn('hashed_password');

        $this->userRepositoryMock->expects($this->once())
            ->method('registerNewUser');

        $this->registerUser->execute();
    }

    public function testValidationFailure()
    {
        $this->expectException(RegisterUserViolateValidationConstraintException::class);

        $this->userMock->expects($this->once())
            ->method('isValid')
            ->willReturn(false);

        $this->registerUser->execute();
    }

    public function testUserEmailAlreadyRegistered()
    {
        $this->expectException(UserEmailAlreadyRegisteredException::class);

        $this->userMock->expects($this->once())
            ->method('validate')
            ->willReturn($this->createMock(ValidationResult::class));
        
        $this->userMock->expects($this->once())
            ->method('isValid')
            ->willReturn(true);

        $this->userRepositoryMock->expects($this->once())
            ->method('isEmailAlreadyRegistered')
            ->willReturn(true);

        $this->registerUser->execute();
    }

    public function testUserDocumentAlreadyRegistered()
    {
        $this->expectException(UserDocumentAlreadyRegisteredException::class);

        $this->userMock->expects($this->once())
        ->method('validate')
        ->willReturn($this->createMock(ValidationResult::class));
    
        $this->userMock->expects($this->once())
            ->method('isValid')
            ->willReturn(true);


        $this->userRepositoryMock->expects($this->once())
            ->method('isEmailAlreadyRegistered')
            ->willReturn(false);

        $this->userRepositoryMock->expects($this->once())
            ->method('isDocumentAlreadyRegistered')
            ->willReturn(true);

        $this->registerUser->execute();
    }
}
