<?php 
namespace App\Infra\Doctrine\Repository;
use App\Domain\Account\User\User;
use App\Domain\Account\User\PlainTextPassword;
use App\Domain\Account\Repository\UserRepository as UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function isEmailAlreadyRegistered(User $user): bool
    {
        return false;
    }

    public function isDocumentAlreadyRegistered(User $user): bool
    {
        return false;
    }

    public function registerNewUser(User $user, PlainTextPassword $plainTextPassword): void
    {
        dd('registerNewUser');
    }
}