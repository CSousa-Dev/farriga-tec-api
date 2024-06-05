<?php

namespace App\Infra\Doctrine\Repository\Devices;

use App\Domain\Devices\Device\Device;
use App\Domain\Devices\Device\Zone\Zones;
use Doctrine\Persistence\ManagerRegistry;
use App\Infra\Doctrine\Entity\Devices\Zone;
use App\Domain\Devices\Device\Zone\Zone as DomainZone;
use App\Infra\Doctrine\Entity\Devices\Device as EntityDevice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Zone>
 */
class ZoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Zone::class);
    }

    public function addNew($deviceId, DomainZone $zone)
    {
        $entityManager = $this->getEntityManager();
        $entityZone = new Zone();
        $entityZone->setPosition($zone->position());
        $entityZone->setAlias($zone->alias());
        $entityZone->setDevice($entityManager->getReference(EntityDevice::class, $deviceId));   
        $entityManager->persist($entityZone);
        $entityManager->flush();
    }

    public function hydrateZones(Zone ...$entityZones): Zones
    {
        $zones = new Zones();
        foreach($entityZones as $entityZone)
        {
            $zone = new DomainZone(
                id: $entityZone->getId(),
                position: $entityZone->getPosition(),
                alias: $entityZone->getAlias(),
            );
            $zones->addZone($zone);
        }
        return $zones;
    }

//    /**
//     * @return Zone[] Returns an array of Zone objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('z')
//            ->andWhere('z.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('z.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Zone
//    {
//        return $this->createQueryBuilder('z')
//            ->andWhere('z.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
