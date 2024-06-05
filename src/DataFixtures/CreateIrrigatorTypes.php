<?php 
namespace App\DataFixtures;

use App\Infra\Doctrine\Entity\Devices\EventType;
use App\Infra\Doctrine\Entity\Devices\IrrigatorType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CreateIrrigatorTypes extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $irrigatioOnEvent = new EventType();
        $irrigatioOnEvent->setName('IRRIGATION_ON');
        $irrigatioOnEvent->setCanEmit(true);
        $irrigatioOnEvent->setCanListen(true);
        $irrigatioOnEvent->setListenKey('DEVICE/{macAddress}/{zone}/{target}/{number}/IRRIGATION');
        $irrigatioOnEvent->setEmitKey('API/{macAddress}/{zone}/{target}/{number}/IRRIGATION');
        $manager->persist($irrigatioOnEvent);

        $irrigatioOffEvent = new EventType();
        $irrigatioOffEvent->setName('IRRIGATION_OFF');
        $irrigatioOffEvent->setCanEmit(true);
        $irrigatioOffEvent->setCanListen(true);
        $irrigatioOffEvent->setListenKey('DEVICE/{macAddress}/{zone}/{target}/{number}/IRRIGATION');
        $irrigatioOffEvent->setEmitKey('API/{macAddress}/{zone}/{target}/{number}/IRRIGATION');
        $manager->persist($irrigatioOffEvent);
        
        $irrigatioStartEvent = new EventType();
        $irrigatioStartEvent->setName('IRRIGATION_START');
        $irrigatioStartEvent->setCanEmit(true);
        $irrigatioStartEvent->setCanListen(true);
        $irrigatioStartEvent->setListenKey('DEVICE/{macAddress}/{zone}/{target}/{number}/IRRIGATE');
        $irrigatioStartEvent->setEmitKey('API/{macAddress}/{zone}/{target}/{number}/IRRIGATE');
        $manager->persist($irrigatioStartEvent);
        
        $irrigatioStopEvent = new EventType();
        $irrigatioStopEvent->setName('IRRIGATION_STOP');
        $irrigatioStopEvent->setCanEmit(true);
        $irrigatioStopEvent->setCanListen(true);
        $irrigatioStopEvent->setListenKey('DEVICE/{macAddress}/{zone}/{target}/{number}/IRRIGATE');
        $irrigatioStopEvent->setEmitKey('API/{macAddress}/{zone}/{target}/{number}/IRRIGATE');
        $manager->persist($irrigatioStartEvent);

        $irrigationChangeWateringTimeEvent = new EventType();
        $irrigationChangeWateringTimeEvent->setName('IRRIGATION_CHANGE_WATERING_TIME');
        $irrigationChangeWateringTimeEvent->setCanEmit(true);
        $irrigationChangeWateringTimeEvent->setCanListen(true);
        $irrigationChangeWateringTimeEvent->setListenKey('DEVICE/{macAddress}/{zone}/{target}/{number}/WATERING_TIME');
        $irrigationChangeWateringTimeEvent->setEmitKey('API/{macAddress}/{zone}/{target}/{number}/WATERING_TIME');
        $manager->persist($irrigationChangeWateringTimeEvent);

        $irrigationChangeCheckIntervalEvent = new EventType();
        $irrigationChangeCheckIntervalEvent->setName('IRRIGATION_CHANGE_CHECK_INTERVAL');
        $irrigationChangeCheckIntervalEvent->setCanEmit(true);
        $irrigationChangeCheckIntervalEvent->setCanListen(true);
        $irrigationChangeCheckIntervalEvent->setListenKey('DEVICE/{macAddress}/{zone}/{target}/{number}/CHECK_INTERVAL');
        $irrigationChangeCheckIntervalEvent->setEmitKey('API/{macAddress}/{zone}/{target}/{number}/CHECK_INTERVAL');
        $manager->persist($irrigationChangeCheckIntervalEvent);

        $irrigator = new IrrigatorType();
        $irrigator->setName('IRRIGATOR');
        $irrigator->setCanChangeCheckInterval(true);
        $irrigator->setCanChangeWateringTime(true);
        $irrigator->setCanManualControlIrrigation(true);
        $irrigator->setCanTurnOnTurnOff(true);
        $irrigator->setLabel('Irrigador');
        $irrigator->addEventConfig($irrigatioOnEvent);
        $irrigator->addEventConfig($irrigatioOffEvent);
        $irrigator->addEventConfig($irrigatioStartEvent);
        $irrigator->addEventConfig($irrigatioStopEvent);
        $irrigator->addEventConfig($irrigationChangeWateringTimeEvent);
        $irrigator->addEventConfig($irrigationChangeCheckIntervalEvent);
        $manager->persist($irrigator);

        $manager->flush();
    }
}