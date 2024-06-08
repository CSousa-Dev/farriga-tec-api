<?php

namespace App\Infra\Doctrine\Repository\Devices;

use Doctrine\Persistence\ManagerRegistry;
use App\Infra\Doctrine\Entity\Devices\Zone;
use App\Infra\Doctrine\Entity\Devices\Irrigator;
use App\Domain\Devices\Device\Irrigator\Irrigators;
use App\Infra\Doctrine\Entity\Devices\IrrigatorType;
use App\Domain\Devices\Repository\IIrrigatorRepository;
use App\Domain\Devices\Device\Irrigator\IrrigatorActionsConfig;
use App\Infra\Doctrine\Repository\Devices\EventConfigRepository;
use App\Domain\Devices\Device\Irrigator\Irrigator as DomainIrrigator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Irrigator>
 */
class IrrigatorRepository extends ServiceEntityRepository implements IIrrigatorRepository
{
    public function __construct(
        private IrrigatorTypeRepository $irrigatorTypeRepository,
        private EventConfigRepository $eventTypeRepository,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, Irrigator::class);
    }

    public function buildIrrigatorModel(int $modelId): DomainIrrigator
    {
        
        $irrigatorType = $this->irrigatorTypeRepository->find($modelId);

        if($irrigatorType === null){
            throw new \DomainException("Modelo de irrigador não localizado.");
        }     
        
        /**
         * @var IrrigatorType $irrigatorType
         */
        
        return new DomainIrrigator(
            model: $irrigatorType->getModel(),
            name: $irrigatorType->getLabel(),
            actionsConfig: new IrrigatorActionsConfig(
                $irrigatorType->canManualControlIrrigation(),
                $irrigatorType->canChangeWateringTime(),
                $irrigatorType->canChangeCheckInterval(),
                $irrigatorType->canTurnOnTurnOff()        
            )
        );
    }

    public function modelExists(int $modelId): bool
    {
        return $this->irrigatorTypeRepository->find($modelId) !== null;
    }

    public function addNew(int $zoneId, DomainIrrigator $irrigator): void
    {
        $entityManager = $this->getEntityManager();
        $entityIrrigator = new Irrigator();
        $entityIrrigator->setPosition($irrigator->position());
        $entityIrrigator->setZone($entityManager->getReference(Zone::class, $zoneId)); 
        $entityIrrigator->setAlias($irrigator->alias());
        $entityIrrigator->setIrrigatorType($this->irrigatorTypeRepository->findByModelName($irrigator->model));

        $entityManager->persist($entityIrrigator);
        $entityManager->flush();
    }

    public function hydrateIrrigator(Irrigator $irrigator): DomainIrrigator
    {       
        $events = [];

        foreach($irrigator->getIrrigatorType()->getIrrigatorEvents() as $relationIrrigatorEvent)
        {
            $events[] = $this->eventTypeRepository->hydrate($relationIrrigatorEvent->getEvent());
        }


        $domainIrrigator = new DomainIrrigator(
            id: $irrigator->getId(),
            position: $irrigator->getPosition(),
            model: $irrigator->getIrrigatorType()->getModel(),
            name: $irrigator->getIrrigatorType()->getLabel(),
            alias: $irrigator->getAlias(),
            actionsConfig: new IrrigatorActionsConfig(
                canManualControllIrrigation: $irrigator->getIrrigatorType()->canManualControlIrrigation(),
                canChangeWateringTime: $irrigator->getIrrigatorType()->canChangeWateringTime(),
                canChangeCheckInterval: $irrigator->getIrrigatorType()->canChangeCheckInterval(),
                canTurOnTurnOff: $irrigator->getIrrigatorType()->canTurnOnTurnOff()
            )
        );

        $domainIrrigator->addCondifguredEvents(...$events);
        return $domainIrrigator;
    }

    public function hydrateIrrigators(Irrigator ...$entityIrrigators): Irrigators
    {
        $irrigators = new Irrigators();

        foreach($entityIrrigators as $entityIrrigator)
        {
            $irrigators->addIrrigator($this->hydrateIrrigator($entityIrrigator));
        }

        return $irrigators;
    }


//    /**
//     * @return Irrigator[] Returns an array of Irrigator objects
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

//    public function findOneBySomeField($value): ?Irrigator
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
