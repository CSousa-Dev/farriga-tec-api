<?php

namespace App\DataFixtures\Device;

use Doctrine\Persistence\ObjectManager;
use App\Infra\Doctrine\Entity\Device\Event;
use App\Infra\Doctrine\Entity\Device\EventType;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CreateEvents extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $measureType = new EventType();
        $measureType->setType('MEASURE');
        $manager->persist($measureType);
        $manager->flush();

        $powerType = new EventType();
        $powerType->setType('POWER');
        $manager->persist($powerType);
        $manager->flush();

        $activationType = new EventType();
        $activationType->setType('ACTIVATION');
        $manager->persist($activationType);
        $manager->flush();

        $notificationType = new EventType();
        $notificationType->setType('NOTIFICATION');
        $manager->persist($notificationType);
        $manager->flush();

        $configurationType = new EventType();
        $configurationType->setType('CONFIGURATION');
        $manager->persist($configurationType);
        $manager->flush();

        $threshold = new Event();
        $threshold->setName('threshold');
        $threshold->setListenKey('{macAddress}/status/limiar/{target}');
        $threshold->setNotifyKey('{macAddress}/limiar/{target}');
        $threshold->setCanListen(true);
        $threshold->setCanNotify(true);
        $threshold->setType($configurationType);
        $manager->persist($threshold);
        $manager->flush();

        $this->addReference('threshold', $threshold);

        $measure = new Event();
        $measure->setName('measure');
        $measure->setListenKey('{macAddress}/medicao/{target}');
        $measure->setCanListen(true);
        $measure->setCanNotify(false);
        $measure->setType($measureType);
        $manager->persist($measure);
        $manager->flush();

        $this->addReference('measure', $measure);

        $utilization = new Event();
        $utilization->setName('utilization');
        $utilization->setNotifyKey('{macAddress}/utilizacao/{target}');
        $utilization->setListenKey('{macAddress}/status/utilizacao/{target}');
        $utilization->setCanListen(true);
        $utilization->setCanNotify(true);
        $utilization->setType($powerType);
        $manager->persist($utilization); 
        $manager->flush();

        $this->addReference('utilization', $utilization);

        $activation = new Event();
        $activation->setName('activation');
        $activation->setListenKey('{macAddress}/status/ativacao/{target}');
        $activation->setNotifyKey('{macAddress}/ativacao/{target}');
        $activation->setCanListen(true);
        $activation->setCanNotify(true);
        $activation->setType($activationType);
        $manager->persist($activation);
        $manager->flush();

        $this->addReference('activation', $activation);

        $notification = new Event();
        $notification->setName('notification');
        $notification->setListenKey('{macAddress}/notificacao/{target}');
        $notification->setCanListen(true);
        $notification->setCanNotify(false);
        $notification->setType($notificationType);
        $manager->persist($notification);
        $manager->flush();

        $this->addReference('notification', $notification);

        $irrigationTime = new Event();
        $irrigationTime->setName('irrigation_time');
        $irrigationTime->setListenKey('{macAddress}/status/tempo_irrigacao/{target}');
        $irrigationTime->setNotifyKey('{macAddress}/tempo_irrigacao/{target}');
        $irrigationTime->setCanListen(true);
        $irrigationTime->setCanNotify(true);
        $irrigationTime->setType($configurationType);
        $manager->persist($irrigationTime);
        $manager->flush();

        $this->addReference('irrigationTime', $irrigationTime);

        $irrigationInterval = new Event();
        $irrigationInterval->setName('irrigation_interval');
        $irrigationInterval->setListenKey('{macAddress}/status/intervalo_irrigacao/{target}');
        $irrigationInterval->setNotifyKey('{macAddress}/intervalo_irrigacao/{target}');
        $irrigationInterval->setCanListen(true);
        $irrigationInterval->setCanNotify(true);
        $irrigationInterval->setType($configurationType);
        $manager->persist($irrigationInterval);
        $manager->flush();

        $this->addReference('irrigationInterval', $irrigationInterval);

        $usageMode = new Event();
        $usageMode->setName('usage_mode');
        $usageMode->setListenKey('{macAddress}/status/modo/{target}');
        $usageMode->setNotifyKey('{macAddress}/modo/{target}');
        $usageMode->setCanListen(true);
        $usageMode->setCanNotify(true);
        $usageMode->setType($configurationType);
        $manager->persist($usageMode);
        $manager->flush();

        $this->addReference('usageMode', $usageMode);
    }
}
