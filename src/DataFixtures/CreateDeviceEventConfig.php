<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Infra\Doctrine\Entity\Devices\EventType;
use App\Infra\Doctrine\Entity\Devices\DeviceType;
use App\Infra\Doctrine\Entity\Account\DocumentType;

class CreateDeviceEventConfig extends Fixture
{
    public function load(ObjectManager $manager): void
    {        
        $deviceTurnOnEvent = new EventType();
        $deviceTurnOnEvent->setName('DEVICE_TURN_ON');
        $deviceTurnOnEvent->setCanEmit(true);
        $deviceTurnOnEvent->setCanListen(true);
        $deviceTurnOnEvent->setListenKey('DEVICE/{macAddress}/POWER');
        $deviceTurnOnEvent->setEmitKey('API/{macAddress}/POWER');

        $manager->persist($deviceTurnOnEvent);

        $deviceTurnOffEvent = new EventType();
        $deviceTurnOffEvent->setName('DEVICE_TURN_OFF');
        $deviceTurnOffEvent->setCanEmit(true);
        $deviceTurnOffEvent->setCanListen(true);
        $deviceTurnOffEvent->setListenKey('DEVICE/{macAddress}/POWER');
        $deviceTurnOffEvent->setEmitKey('API/{macAddress}/POWER');

        $manager->persist($deviceTurnOffEvent);

        $deviceManualUsageEvent = new EventType();
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
        $farrigaOneDeviceType->addEventConfig($deviceTurnOnEvent);
        $farrigaOneDeviceType->addEventConfig($deviceTurnOffEvent);
        $farrigaOneDeviceType->addEventConfig($deviceManualUsageEvent);

        $manager->persist($farrigaOneDeviceType);
        $manager->flush();
    }
}
