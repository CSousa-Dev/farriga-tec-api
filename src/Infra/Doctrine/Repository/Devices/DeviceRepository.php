<?php

namespace App\Infra\Doctrine\Repository\Devices;

use Doctrine\Persistence\ManagerRegistry;
use App\Infra\Doctrine\Entity\Devices\Device;
use App\Domain\Devices\Repository\IDeviceRepository;
use App\Domain\Devices\Device\Device as DomainDevice;
use App\Domain\Devices\Device\DeviceType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Device>
 */
class DeviceRepository extends ServiceEntityRepository implements IDeviceRepository
{
    public function __construct(
        private DeviceTypeRepository $deviceTypeRepository,
        private ZoneRepository $zoneRepository,
        private SensorRepository $sensorRepository,
        ManagerRegistry $registry)
    {
        parent::__construct($registry, Device::class);
    }

    public function addNew(DomainDevice $domainDevice): void
    {
        $entityManager = $this->getEntityManager();
        $entityDevice = new Device();
        $deviceType = $this->deviceTypeRepository->find($domainDevice->model->id);
        $entityDevice->setMacAddress($domainDevice->macAddress);
        $entityDevice->setDeviceType($deviceType);
        $entityDevice->setPower(true);

        $entityManager->persist($entityDevice);
        $entityManager->flush();
    }

    public function addNewZone(DomainDevice $device, int $zonePosition): void
    {
        $this->zoneRepository->addNew($device->id, $device->zones()->getZone($zonePosition));
    }

    public function addNewSensor(DomainDevice $device, int $zonePosition, int $sensorPosition): void
    {
        $zone = $device->zones()->getZone($zonePosition);
        $sensor = $zone->getSensors()->getSensor($sensorPosition);
        $this->sensorRepository->addNew($zone->id(), $sensor);
    }

    public function isMacAddressInUse(string $macAddress): bool
    {
        return $this->findOneBy(['macAddress' => $macAddress]) !== null;
    }

    public function findModel(int $modelId): DeviceType
    {
        
        if(!$this->modelExists($modelId)){
            throw new \DomainException("Modelo não localizado.");
        }

        return $this->deviceTypeRepository->findModel($modelId);
    }

    public function modelExists(int $modelId): bool
    {
        return $this->deviceTypeRepository->findModel($modelId) !== null;
    }

    public function findDeviceByMacAddress(string $macAddress): DomainDevice | null
    {
        $device = $this->findOneBy(['macAddress' => $macAddress]);

        if($device === null) return null;

        return $this->hydrateDomainDevice($device);
    }

    public function hydrateDomainDevice(Device $device): DomainDevice
    {
        $this->getEntityManager()->refresh($device);
        $zones = $this->zoneRepository->hydrateZones(...$device->getZones());

        return new DomainDevice(
            macAddress: $device->getMacAddress(), 
            id: $device->getId(),
            model: $this->deviceTypeRepository->hydatreDeviceDomainModel($device->getDeviceType()),
            power: $device->isPower(),
            zones: $zones
        );
    }


//    /**
//     * @return Device[] Returns an array of Device objects
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

//    public function findOneBySomeField($value): ?Device
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
