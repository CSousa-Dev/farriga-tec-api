<?php

use PHPUnit\Framework\TestCase;
use App\Domain\Account\User\User;
use App\Domain\Account\User\Email;
use App\Domain\Account\User\Address;
use App\Domain\Account\Documents\Cpf;
use App\Domain\Validations\ValidationResult;
use App\Domain\Account\User\ValidationRules\UserValidation;

class UserTest extends TestCase
{
    public function testIfUserValidatesAllHisDataWhenCallingValidate()
    {
        // Mock dependencies
        $emailMock          = $this->createMock(Email::class);
        $documentMock       = $this->createMock(Cpf::class);
        $addressMock        = $this->createMock(Address::class);
        $userValidationMock = $this->createMock(UserValidation::class);

        // Setup mock methods
        $emailMock->expects($this->atLeastOnce())
                ->method('validate');

        $documentMock->expects($this->atLeastOnce())
                    ->method('validate');

        $addressMock->expects($this->atLeastOnce())
                    ->method('validate');

        $userValidationMock->expects($this->atLeastOnce())
                             ->method('validateFromUser')
                             ->willReturn(new ValidationResult())
                             ->with($this->isInstanceOf(User::class));
 
         // Create User instance with mock dependencies
        $user = new User(
            '123',
            'John',
            'Doe',
            $documentMock,
            $userValidationMock,
            new \DateTime(),
            $emailMock
        );

        $user->changeHomeAddress($addressMock);

        // Call validate method
        $user->validate();
    }

}
