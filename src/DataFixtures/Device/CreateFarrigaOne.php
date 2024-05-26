<?php 
namespace App\DataFixtures\Device;

use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\Device\CreateEvents;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Infra\Doctrine\Entity\Device\Device;
use App\Infra\Doctrine\Entity\Device\Sensor;
use App\Infra\Doctrine\Entity\Device\Sprinkler;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CreateFarrigaOne extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $usageModeEvent             = $this->getReference('usageMode');
        $thresholdEvent             = $this->getReference('threshold');
        $measureEvent               = $this->getReference('measure');
        $utilizationEvent           = $this->getReference('utilization');
        $activationEvent            = $this->getReference('activation');
        $notificationEvent          = $this->getReference('notification');
        $irrigationTimeEvent        = $this->getReference('irrigationTime');
        $irrigationIntervalEvent    = $this->getReference('irrigationInterval');

        $device = new Device();
        $device->setMacAddress('farriga-one')
        ->setCommunicationStatus('ONLINE')
        ->setPowerStatus('OFF')
        ->setModel('Farriga One')
        ->setUsageMode('AUTO')
        ->setWaitingForPowerStatusConfirmation(false)
        ->addEvent($notificationEvent)
        ->addEvent($usageModeEvent)
        ->addEvent($utilizationEvent);
        
        $temperatureSensor = new Sensor();
        $temperatureSensor->setName('temperature')
        ->setUnitMeasurement('°C')
        ->setPowerStatus('OFF')
        ->setCanControllIrrigation(true)
        ->setControllValue('25')
        ->setWaitingForControllValueConfirmation(false)
        ->addEvent($measureEvent)
        ->addEvent($thresholdEvent)
        ->addEvent($utilizationEvent)
        ->addEvent($notificationEvent);
        
        $device->addSensor($temperatureSensor);

        $soilMoistureSensor = new Sensor();
        $soilMoistureSensor->setName('soil_moisture')
        ->setUnitMeasurement('%')
        ->setPowerStatus('OFF')
        ->setCanControllIrrigation(true)
        ->setControllValue('50')
        ->setWaitingForControllValueConfirmation(false)
        ->addEvent($measureEvent)
        ->addEvent($thresholdEvent)
        ->addEvent($utilizationEvent)
        ->addEvent($notificationEvent);

        $device->addSensor($soilMoistureSensor);

        $airHumiditySensor = new Sensor();
        $airHumiditySensor->setName('air_humidity')
        ->setUnitMeasurement('%')
        ->setPowerStatus('OFF')
        ->setCanControllIrrigation(true)
        ->setControllValue(30)
        ->setWaitingForControllValueConfirmation(false)
        ->addEvent($measureEvent)
        ->addEvent($thresholdEvent)
        ->addEvent($utilizationEvent)
        ->addEvent($notificationEvent);

        $device->addSensor($airHumiditySensor);

        $rainSensor = new Sensor();
        $rainSensor->setName('rain')
        ->setPowerStatus('OFF')
        ->setCanControllIrrigation(false)
        ->setWaitingForControllValueConfirmation(false)
        ->addEvent($measureEvent)
        ->addEvent($utilizationEvent)
        ->addEvent($notificationEvent);

        $device->addSensor($rainSensor);

        $sprinkler = new Sprinkler();
        $sprinkler->setNumber(1)
        ->setType('rotating')
        ->setModel('rotating')
        ->setPowerStatus('OFF')
        ->setWaitingForPowerStatusConfirmation(false)
        ->setIntervalForActvation(60)
        ->setActivateInterval(30)
        ->addEvent($utilizationEvent)
        ->addEvent($notificationEvent)
        ->addEvent($activationEvent)
        ->addEvent($irrigationTimeEvent)
        ->addEvent($irrigationIntervalEvent); 

        $device->addSprinkler($sprinkler);

        $manager->persist($device);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CreateEvents::class,
        ];
    }
}