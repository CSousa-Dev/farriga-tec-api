<?php

namespace App\Infra\Doctrine\Repository\Devices;

use Doctrine\Persistence\ManagerRegistry;
use App\Infra\Doctrine\Entity\Devices\Zone;
use App\Infra\Doctrine\Entity\Devices\Sensor;
use App\Infra\Doctrine\Entity\Devices\SensorType;
use App\Domain\Devices\Device\Sensor\TresholdType;
use App\Domain\Devices\Repository\ISensorRepository;
use App\Domain\Devices\Device\Sensor\SensorActionsConfig;
use App\Domain\Devices\Device\Sensor\Sensor as DomainSensor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Sensor>
 */
class SensorRepository extends ServiceEntityRepository implements ISensorRepository
{
    public function __construct(
        private SensorTypeRepository $sensorTypeRepository,   
        private EventConfigRepository $eventTypeRepository, 
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, Sensor::class);
    }

    public function buildSensorModel(int $modelId): DomainSensor
    {
        
        $sensorType = $this->sensorTypeRepository->find($modelId);

        if($sensorType === null){
            throw new \DomainException("Modelo de sensor não localizado.");
        }     
        
        /**
         * @var SensorType $sensorType
         */
        
        return new DomainSensor(
            model: $sensorType->getModel(),
            name: $sensorType->getLabel(),
            actionsConfig: new SensorActionsConfig(
                $sensorType->isCanControllStartStop(),
                $sensorType->isCanChangeTreshold(),
                TresholdType::EXACT
            )
        );
    }

    public function modelExists(int $modelId): bool
    {
        return $this->sensorTypeRepository->find($modelId) !== null;
    }

    public function addNew(int $zoneId, DomainSensor $sensor): void
    {
        $entityManager = $this->getEntityManager();
        $entitySensor = new Sensor();
        $entitySensor->setPosition($sensor->position());
        $entitySensor->setZone($entityManager->getReference(Zone::class, $zoneId)); 
        $entitySensor->setAlias($sensor->alias());
        $entitySensor->setSensorType($this->sensorTypeRepository->findByModelName($sensor->model));

        $entityManager->persist($entitySensor);
        $entityManager->flush();
    }

    public function hydrateSensor(Sensor $sensor): DomainSensor
    {
        $events = [];

        foreach($sensor->getSensorType()->getSensorEvents() as $relationSensorEvent)
        {
            $events[] = $this->eventTypeRepository->hydrate($relationSensorEvent->getEvent());
        }


        $domainSensor = new DomainSensor(
            id: $sensor->getId(),
            position: $sensor->getPosition(),
            model: $sensor->getSensorType()->getModel(),
            name: $sensor->getSensorType()->getLabel(),
            alias: $sensor->getAlias(),
            actionsConfig: new SensorActionsConfig(
                $sensor->getSensorType()->isCanControllStartStop(),
                $sensor->getSensorType()->isCanChangeTreshold(),
                TresholdType::EXACT
            )
        );

        $domainSensor->addCondifguredEvents(...$events);
        
        return $domainSensor;
    }

//    /**
//     * @return Sensor[] Returns an array of Sensor objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sensor
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
