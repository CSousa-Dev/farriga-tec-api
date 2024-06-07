<?php

namespace App\Infra\Doctrine\Repository\Devices;

use App\Domain\Devices\Device\DeviceType;
use Doctrine\Persistence\ManagerRegistry;
use App\Infra\Doctrine\Entity\Devices\Device;
use App\Domain\Devices\Repository\IDeviceRepository;
use App\Domain\Devices\Device\Device as DomainDevice;
use App\Infra\Doctrine\Repository\Account\UserRepository;
use App\Domain\Account\Repository\IUserDevicesListRepository;
use App\Infra\Doctrine\Repository\Devices\IrrigatorRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Device>
 */
class DeviceRepository extends ServiceEntityRepository implements IDeviceRepository, IUserDevicesListRepository
{
    public function __construct(
        private DeviceTypeRepository $deviceTypeRepository,
        private ZoneRepository $zoneRepository,
        private SensorRepository $sensorRepository,
        private IrrigatorRepository $irrigatorRepository,
        private UserRepository $userRepository,
        ManagerRegistry $registry)
    {
        parent::__construct($registry, Device::class);
    }

    public function currentLinkedUserEmail(string $macAddress): string
    {
        $device = $this->findOneBy(['macAddress' => $macAddress]);
        $owner = $device->getOwner();
        return $owner->getEmail()->getAddress();
    }

    public function deviceExists(string $macAddress): bool
    {
        if($this->isMacAddressInUse($macAddress))
        {
            return true;
        }

        return false;
    }

    public function isDeviceAlreadyLinked(string $macAddress): bool
    {
        return $this->findOneBy(['macAddress' => $macAddress])->getOwner() !== null;
    }

    public function linkDeviceToUser(string $macAddress, string $userEmail): void
    {
        $device = $this->findOneBy(['macAddress' => $macAddress]);
        $user = $this->userRepository->getUserByEmailAddress($userEmail);
        $device->setOwner($user);
        $this->getEntityManager()->flush();
    }

    public function unlinkDevice(string $macAddress): void
    {
        $device = $this->findOneBy(['macAddress' => $macAddress]);
        $device->setOwner(null);
        $this->getEntityManager()->flush();
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

    public function addNewIrrigator(DomainDevice $device, int $zonePosition, int $irrigatorPosition): void
    {
        $zone = $device->zones()->getZone($zonePosition);
        $irrigator = $zone->getIrrigators()->getIrrigator($irrigatorPosition);
        $this->irrigatorRepository->addNew($zone->id(), $irrigator);
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
}
