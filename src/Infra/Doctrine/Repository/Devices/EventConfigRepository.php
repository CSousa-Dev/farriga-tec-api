<?php

namespace App\Infra\Doctrine\Repository\Devices;

use App\Domain\Devices\Events\EventConfig as DomainEventConfig;
use Doctrine\Persistence\ManagerRegistry;
use App\Infra\Doctrine\Entity\Devices\EventConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<EventConfig>
 */
class EventConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventConfig::class);
    }

    public function hydrate(EventConfig $event): DomainEventConfig
    {
        return new DomainEventConfig(
            eventName: $event->getName(),
            canListen: $event->isCanListen(),
            canEmit: $event->isCanEmit(),
            listenKey: $event->getListenKey(),
            emitKey: $event->getEmitKey()
        );
    }

//    /**
//     * @return EventConfig[] Returns an array of EventConfig objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EventConfig
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
