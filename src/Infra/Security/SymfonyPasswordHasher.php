<?php 

use App\Domain\Account\User\User;
use App\Domain\Account\User\PasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SymfonyPasswordHasher implements PasswordHasher
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasherInterface,
        private User $sercurityUser
    )
    {

    }

    public function hash(User $user , string $plainTextPassword): string
    {

        return $this->userPasswordHasherInterface->hashPassword($plainTextPassword);
    }

    public function verify(string $password, string $hash): bool
    {
        return false;
    }
}