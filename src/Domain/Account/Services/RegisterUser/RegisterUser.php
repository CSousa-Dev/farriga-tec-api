<?php
namespace App\Domain\Account\Services;

use App\Domain\Account\User\User;
use App\Domain\Repository\Account\UserRepository;
use App\Domain\Account\Services\RegisterUser\UserEmailAlreadyRegisteredException;
use App\Domain\Account\Services\RegisterUser\UserDocumentAlreadyRegisteredException;
use App\Domain\Account\Services\RegisterUser\RegisterUserViolateValidationConstraintException;
use App\Domain\Account\User\PasswordHasher;

class RegisterUser
{
    public function __construct(
        private User $user,
        private UserRepository $userRepository,
        private PasswordHasher $passwordHasher
    ){}

    public function execute(): void
    {
        $this->validateUser();
        $this->checkUserEmailAlreadyRegistered();
        $this->checkUserDocumentAlreadyRegistered();
        $this->userRepository->registerNewUser(
            $this->user,
            $this->passwordHasher->hash($this->user->plainTextPassword()->password)
        );
    }

    private function validateUser()
    {
        $validationResult = $this->user->validate();
        if(!$this->user->isValid())
            throw new RegisterUserViolateValidationConstraintException($validationResult, $this->user);
    }

    private function checkUserEmailAlreadyRegistered()
    {
        if($this->userRepository->isEmailAlreadyRegistered($this->user));
            throw new UserEmailAlreadyRegisteredException($this->user);
    }

    private function checkUserDocumentAlreadyRegistered()
    {
        if($this->userRepository->isDocumentAlreadyRegistered($this->user));
            throw new UserDocumentAlreadyRegisteredException($this->user);
    }
}