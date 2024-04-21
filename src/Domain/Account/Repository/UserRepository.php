<?php
namespace App\Domain\Repository\Account;

use App\Domain\Account\User\User;

interface UserRepository
{
    public function registerNewUser(User $user, $hashPassword): void;
    public function isDocumentAlreadyRegistered(User $user): bool;
    public function isEmailAlreadyRegistered(User $user): bool;
}