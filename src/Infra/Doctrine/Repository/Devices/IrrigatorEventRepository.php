<?php

namespace App\Infra\Doctrine\Repository\Devices;

use Doctrine\Persistence\ManagerRegistry;
use App\Infra\Doctrine\Entity\Devices\IrrigatorEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<IrrigatorEvent>
 */
class IrrigatorEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IrrigatorEvent::class);
    }

//    /**
//     * @return IrrigatorEvent[] Returns an array of IrrigatorEvent objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?IrrigatorEvent
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
