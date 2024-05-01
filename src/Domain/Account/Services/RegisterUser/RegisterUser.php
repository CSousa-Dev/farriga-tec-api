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
    private User $user;
    public function __construct(
        private UserRepository $userRepository,
    ){}

    public function execute(PlainTextPassword $plainTextPassword, User $user,

    ): void
    {
        $this->user = $user;
        $this->validateConstraints($plainTextPassword);
        $this->checkUserEmailAlreadyRegistered();
        $this->checkUserDocumentAlreadyRegistered();
        $this->userRepository->registerNewUser(
            $this->user,
            $plainTextPassword
        );
    }

    private function validateConstraints($plainTextPassword)
    {
        $validationResult = $this->user->validate();
        $validationResult->addAnotherValidationResult($plainTextPassword->validate());
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