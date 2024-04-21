<?php
namespace App\Domain\Account\Services\RegisterUser;

use App\Domain\Account\User\User;
use App\Domain\Account\Repository\UserRepository;
use App\Domain\Account\Services\RegisterUser\UserEmailAlreadyRegisteredException;
use App\Domain\Account\Services\RegisterUser\UserDocumentAlreadyRegisteredException;
use App\Domain\Account\Services\RegisterUser\RegisterUserViolateValidationConstraintException;
use App\Domain\Account\User\PlainTextPassword;

class RegisterUser
{
    public function __construct(
        private User $user,
        private UserRepository $userRepository,
        private PlainTextPassword $plainTextPassword,
    ){}

    public function execute(): void
    {
        $this->validateConstraints();
        $this->checkUserEmailAlreadyRegistered();
        $this->checkUserDocumentAlreadyRegistered();
        $this->userRepository->registerNewUser(
            $this->user,
            $this->plainTextPassword
        );
    }

    private function validateConstraints()
    {
        $validationResult = $this->user->validate();
        $validationResult->addAnotherValidationResult($this->plainTextPassword->validate());
        if($validationResult->hasErrors())
            throw new RegisterUserViolateValidationConstraintException($validationResult, $this->user);
    }

    private function checkUserEmailAlreadyRegistered()
    {
        if($this->userRepository->isEmailAlreadyRegistered($this->user))
            throw new UserEmailAlreadyRegisteredException($this->user);
    }

    private function checkUserDocumentAlreadyRegistered()
    {
        if($this->userRepository->isDocumentAlreadyRegistered($this->user))
            throw new UserDocumentAlreadyRegisteredException($this->user);
    }
}