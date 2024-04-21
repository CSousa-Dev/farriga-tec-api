<?php 
namespace App\Domain\Account\User;

interface PasswordHasher
{
    public function hash(string $password): string;
    public function verify(string $password, string $hash): bool;
}