<?php

namespace App\Infra\Doctrine\Repository\Devices;

use Doctrine\Persistence\ManagerRegistry;
use App\Infra\Doctrine\Entity\Devices\DeviceType;
use App\Domain\Devices\Device\DeviceType as DeviceDomainModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<DeviceType>
 */
class DeviceTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeviceType::class);
    }

    public function findModel(int $modelId): DeviceDomainModel | null
    {
        $model = $this->findOneBy(["id" => $modelId]);
        if ($model === null) {
            return null;
        }

        return $this->hydatreDeviceDomainModel($model);
    }

    public function hydatreDeviceDomainModel(DeviceType $deviceType): DeviceDomainModel
    {
        return new DeviceDomainModel(
            $deviceType->getId(),
            $deviceType->isUseBluetooth(),
            $deviceType->isUseWifiConnection(),
            $deviceType->isCanPowerControll(),
            $deviceType->canManualControll(),
            $deviceType->getModel()
        );
    }

//    /**
//     * @return DeviceType[] Returns an array of DeviceType objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DeviceType
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
