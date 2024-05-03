<?php 
namespace App\Infra\Doctrine\Repository;
use App\Domain\Account\User\User;
use App\Domain\Account\User\PlainTextPassword;
use App\Infra\Doctrine\Entity\UserSecurityInfo;
use App\Domain\Account\Repository\UserRepository as UserRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function isEmailAlreadyRegistered(User $user): bool
    {
        return false;
    }

    public function isDocumentAlreadyRegistered(User $user): bool
    {
        return false;
    }

    public function registerNewUser(User $user, string $hashedPassword): void
    {
        $securityUser = new UserSecurityInfo();
        $securityUser->setEmail($user->email()->address);
        $securityUser->setPassword($hashedPassword);
        $this->entityManager->persist($securityUser);
        $this->entityManager->flush();
        dd('User registered successfully!');
    }
}