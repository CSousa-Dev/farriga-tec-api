<?php

namespace App\DataFixtures;

use App\Infra\Doctrine\Entity\Devices\DeviceEvent;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Infra\Doctrine\Entity\Devices\DeviceType;
use App\Infra\Doctrine\Entity\Devices\EventConfig;

class CreateDeviceEventConfig extends Fixture
{
    public function load(ObjectManager $manager): void
    {        
        $deviceTurnOnEvent = new EventConfig();
        $deviceTurnOnEvent->setName('DEVICE_TURN_ON');
        $deviceTurnOnEvent->setCanEmit(true);
        $deviceTurnOnEvent->setCanListen(true);
        $deviceTurnOnEvent->setListenKey('DEVICE/{macAddress}/POWER');
        $deviceTurnOnEvent->setEmitKey('API/{macAddress}/POWER');

        $manager->persist($deviceTurnOnEvent);

        $deviceTurnOffEvent = new EventConfig();
        $deviceTurnOffEvent->setName('DEVICE_TURN_OFF');
        $deviceTurnOffEvent->setCanEmit(true);
        $deviceTurnOffEvent->setCanListen(true);
        $deviceTurnOffEvent->setListenKey('DEVICE/{macAddress}/POWER');
        $deviceTurnOffEvent->setEmitKey('API/{macAddress}/POWER');

        $manager->persist($deviceTurnOffEvent);

        $deviceManualUsageEvent = new EventConfig();
        $deviceManualUsageEvent->setName('DEVICE_MANUAL_USAGE');
        $deviceManualUsageEvent->setCanEmit(true);
        $deviceManualUsageEvent->setCanListen(true);
        $deviceManualUsageEvent->setListenKey('DEVICE/{macAddress}/USE_MANUAL');
        $deviceManualUsageEvent->setEmitKey('API/{macAddress}/USE_MANUAL');
        
        $manager->persist($deviceManualUsageEvent);


        $farrigaOneDeviceType = new DeviceType();
        $farrigaOneDeviceType->setModel('FarrigaOne');
        $farrigaOneDeviceType->setUseBluetooth(true);
        $farrigaOneDeviceType->setUseWifiConnection(true);
        $farrigaOneDeviceType->setCanPowerControll(true);
        $farrigaOneDeviceType->setCanManualControll(true);


        $deviceOnEventRelation = new DeviceEvent();
        $deviceOnEventRelation->setEvent($deviceTurnOnEvent);
        $deviceOnEventRelation->setDevice($farrigaOneDeviceType);


        $deviceOffEventRelation = new DeviceEvent();
        $deviceOffEventRelation->setEvent($deviceTurnOffEvent);
        $deviceOffEventRelation->setDevice($farrigaOneDeviceType);

        $deviceManualUsageEventRelation = new DeviceEvent();
        $deviceManualUsageEventRelation->setEvent($deviceManualUsageEvent);
        $deviceManualUsageEventRelation->setDevice($farrigaOneDeviceType);

        $farrigaOneDeviceType->addDeviceEvent($deviceOnEventRelation);
        $farrigaOneDeviceType->addDeviceEvent($deviceOffEventRelation);
        $farrigaOneDeviceType->addDeviceEvent($deviceManualUsageEventRelation);
        
        $manager->persist($farrigaOneDeviceType);
        $manager->flush();
    }
}
