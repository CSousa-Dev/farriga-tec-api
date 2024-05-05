<?php

namespace App\Repository;

use App\Domain\Account\User\User;
use Doctrine\Persistence\ManagerRegistry;
use App\Infra\Doctrine\Entity\UserSecurityInfo;
use App\Infra\Doctrine\Repository\UserSecurityInfoRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Domain\Account\Repository\UserRepository as UserRepositoryInterface;


/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private UserSecurityInfoRepository $userSecurityInfoRepository
    )
    {
        parent::__construct($registry, User::class);
    }

    public function isEmailAlreadyRegistered(User | string $user): bool
    {
        return true;
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
        $this->userSecurityInfoRepository->persist($securityUser);
        $this->userSecurityInfoRepository->flush();
        dd('User registered successfully!');
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
