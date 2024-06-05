<?php 
namespace App\DataFixtures;

use App\Infra\Doctrine\Entity\Devices\EventType;
use App\Infra\Doctrine\Entity\Devices\SensorType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CreateSensorTypes extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sensorMeasureEvent = new EventType();
        $sensorMeasureEvent->setName('SENSOR_MEASURED');
        $sensorMeasureEvent->setCanEmit(false);
        $sensorMeasureEvent->setCanListen(true);
        $sensorMeasureEvent->setListenKey('DEVICE/{macAddress}/{zone}/{target}/{number}/MEASURE');
        $manager->persist($sensorMeasureEvent);

        $sensorTresholdChangeEvent = new EventType();
        $sensorTresholdChangeEvent->setName('SENSOR_TRESHOLD_CHANGE');
        $sensorTresholdChangeEvent->setCanEmit(true);
        $sensorTresholdChangeEvent->setCanListen(true);
        $sensorTresholdChangeEvent->setListenKey('DEVICE/{macAddress}/{zone}/{target}/{number}/TRESHOLD_CHANGE');
        $sensorTresholdChangeEvent->setEmitKey('API/{macAddress}/{zone}/{number}/{target}/{number}/TRESHOLD_CHANGE');
        $manager->persist($sensorTresholdChangeEvent);

        $sensorTurnOnEvent = new EventType();
        $sensorTurnOnEvent->setName('SENSOR_ON');
        $sensorTurnOnEvent->setCanEmit(true);
        $sensorTurnOnEvent->setCanListen(true);
        $sensorTurnOnEvent->setListenKey('DEVICE/{macAddress}/{zone}/{target}/{number}/USAGE');
        $sensorTurnOnEvent->setEmitKey('API/{macAddress}/{zone}/{target}/{number}/USAGE');
        $manager->persist($sensorTurnOnEvent);

        $sensorTurnOffEvent = new EventType();
        $sensorTurnOffEvent->setName('SENSOR_OFF');
        $sensorTurnOffEvent->setCanEmit(true);
        $sensorTurnOffEvent->setCanListen(true);
        $sensorTurnOffEvent->setListenKey('DEVICE/{macAddress}/{zone}/{target}/{number}/USAGE');
        $sensorTurnOffEvent->setEmitKey('API/{macAddress}/{zone}/{target}/{number}/USAGE');
        $manager->persist($sensorTurnOffEvent);

        $temperatureSensor = new SensorType();
        $temperatureSensor->setName('TEMPERATURE');
        $temperatureSensor->setCanChangeTreshold(true);
        $temperatureSensor->setCanControllStartStop(true);
        $temperatureSensor->setLabel('Temperatura');
        $temperatureSensor->setModel('SENSOR-TEMP-001');
        $temperatureSensor->setUnit('°C');
        $temperatureSensor->addCondifguredEvent($sensorMeasureEvent);
        $temperatureSensor->addCondifguredEvent($sensorTresholdChangeEvent);
        $temperatureSensor->addCondifguredEvent($sensorTurnOnEvent);
        $temperatureSensor->addCondifguredEvent($sensorTurnOffEvent);
        $manager->persist($temperatureSensor);

        $airHumiditySensor = new SensorType();
        $airHumiditySensor->setName('AIR_HUMIDITY');
        $airHumiditySensor->setCanChangeTreshold(true);
        $airHumiditySensor->setCanControllStartStop(true);
        $airHumiditySensor->setLabel('Umidade do Ar');
        $airHumiditySensor->setModel('SENSOR-AIR-HUM-001');
        $airHumiditySensor->setUnit('%');
        $airHumiditySensor->addCondifguredEvent($sensorMeasureEvent);
        $airHumiditySensor->addCondifguredEvent($sensorTresholdChangeEvent);
        $airHumiditySensor->addCondifguredEvent($sensorTurnOnEvent);
        $airHumiditySensor->addCondifguredEvent($sensorTurnOffEvent);
        $manager->persist($airHumiditySensor);

        $soilMoistureSensor = new SensorType();
        $soilMoistureSensor->setName('SOIL_MOISTURE');
        $soilMoistureSensor->setCanChangeTreshold(true);
        $soilMoistureSensor->setCanControllStartStop(true);
        $soilMoistureSensor->setLabel('Umidade do Solo');
        $soilMoistureSensor->setModel('SENSOR-SOIL-HUM-001');
        $soilMoistureSensor->setUnit('%');
        $soilMoistureSensor->addCondifguredEvent($sensorMeasureEvent);
        $soilMoistureSensor->addCondifguredEvent($sensorTresholdChangeEvent);
        $soilMoistureSensor->addCondifguredEvent($sensorTurnOnEvent);
        $soilMoistureSensor->addCondifguredEvent($sensorTurnOffEvent);
        $manager->persist($soilMoistureSensor);

        $rainSensor = new SensorType();
        $rainSensor->setName('RAIN');
        $rainSensor->setCanChangeTreshold(false);
        $rainSensor->setCanControllStartStop(true);
        $rainSensor->setLabel('Chuva');
        $rainSensor->setModel('SENSOR-RAIN-001');
        $rainSensor->addCondifguredEvent($sensorMeasureEvent);
        $rainSensor->addCondifguredEvent($sensorTurnOnEvent);
        $rainSensor->addCondifguredEvent($sensorTurnOffEvent);
        $manager->persist($rainSensor);

        $manager->flush();
    }
}