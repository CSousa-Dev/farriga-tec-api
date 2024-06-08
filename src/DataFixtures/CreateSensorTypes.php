<?php 
namespace App\DataFixtures;

use App\Infra\Doctrine\Entity\Devices\EventConfig;
use App\Infra\Doctrine\Entity\Devices\SensorEvent;
use App\Infra\Doctrine\Entity\Devices\SensorType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CreateSensorTypes extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sensorMeasureEvent = new EventConfig();
        $sensorMeasureEvent->setName('SENSOR_MEASURED');
        $sensorMeasureEvent->setCanEmit(false);
        $sensorMeasureEvent->setCanListen(true);
        $sensorMeasureEvent->setListenKey('DEVICE/{macAddress}/{zone}/{target}/{number}/MEASURE');
        $manager->persist($sensorMeasureEvent);

        $sensorTresholdChangeEvent = new EventConfig();
        $sensorTresholdChangeEvent->setName('SENSOR_TRESHOLD_CHANGE');
        $sensorTresholdChangeEvent->setCanEmit(true);
        $sensorTresholdChangeEvent->setCanListen(true);
        $sensorTresholdChangeEvent->setListenKey('DEVICE/{macAddress}/{zone}/{target}/{number}/TRESHOLD_CHANGE');
        $sensorTresholdChangeEvent->setEmitKey('API/{macAddress}/{zone}/{number}/{target}/{number}/TRESHOLD_CHANGE');
        $manager->persist($sensorTresholdChangeEvent);

        $sensorTurnOnEvent = new EventConfig();
        $sensorTurnOnEvent->setName('SENSOR_ON');
        $sensorTurnOnEvent->setCanEmit(true);
        $sensorTurnOnEvent->setCanListen(true);
        $sensorTurnOnEvent->setListenKey('DEVICE/{macAddress}/{zone}/{target}/{number}/USAGE');
        $sensorTurnOnEvent->setEmitKey('API/{macAddress}/{zone}/{target}/{number}/USAGE');
        $manager->persist($sensorTurnOnEvent);

        $sensorTurnOffEvent = new EventConfig();
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

        $temperatureSensorEventMeasureRelation = new SensorEvent();
        $temperatureSensorEventMeasureRelation->setEvent($sensorMeasureEvent);
        $temperatureSensorEventMeasureRelation->setSensorType($temperatureSensor);

        $temperatureSensorEventTresholdChangeRelation = new SensorEvent();
        $temperatureSensorEventTresholdChangeRelation->setEvent($sensorTresholdChangeEvent);
        $temperatureSensorEventTresholdChangeRelation->setSensorType($temperatureSensor);

        $temperatureSensorEventTurnOnRelation = new SensorEvent();
        $temperatureSensorEventTurnOnRelation->setEvent($sensorTurnOnEvent);
        $temperatureSensorEventTurnOnRelation->setSensorType($temperatureSensor);

        $temperatureSensorEventTurnOffRelation = new SensorEvent();
        $temperatureSensorEventTurnOffRelation->setEvent($sensorTurnOffEvent);
        $temperatureSensorEventTurnOffRelation->setSensorType($temperatureSensor);

        $temperatureSensor->addSensorEvent($temperatureSensorEventMeasureRelation);
        $temperatureSensor->addSensorEvent($temperatureSensorEventTresholdChangeRelation);
        $temperatureSensor->addSensorEvent($temperatureSensorEventTurnOnRelation);
        $temperatureSensor->addSensorEvent($temperatureSensorEventTurnOffRelation);

        $manager->persist($temperatureSensor);

        $airHumiditySensor = new SensorType();
        $airHumiditySensor->setName('AIR_HUMIDITY');
        $airHumiditySensor->setCanChangeTreshold(true);
        $airHumiditySensor->setCanControllStartStop(true);
        $airHumiditySensor->setLabel('Umidade do Ar');
        $airHumiditySensor->setModel('SENSOR-AIR-HUM-001');
        $airHumiditySensor->setUnit('%');

        $airHumidityEventMeasureRelation = new SensorEvent();
        $airHumidityEventMeasureRelation->setEvent($sensorMeasureEvent);
        $airHumidityEventMeasureRelation->setSensorType($airHumiditySensor);

        $airHumidityEventTresholdChangeRelation = new SensorEvent();
        $airHumidityEventTresholdChangeRelation->setEvent($sensorTresholdChangeEvent);
        $airHumidityEventTresholdChangeRelation->setSensorType($airHumiditySensor);

        $airHumidityEventTurnOnRelation = new SensorEvent();
        $airHumidityEventTurnOnRelation->setEvent($sensorTurnOnEvent);
        $airHumidityEventTurnOnRelation->setSensorType($airHumiditySensor);

        $airHumidityEventTurnOffRelation = new SensorEvent();
        $airHumidityEventTurnOffRelation->setEvent($sensorTurnOffEvent);
        $airHumidityEventTurnOffRelation->setSensorType($airHumiditySensor);

        $airHumiditySensor->addSensorEvent($airHumidityEventMeasureRelation);
        $airHumiditySensor->addSensorEvent($airHumidityEventTresholdChangeRelation);
        $airHumiditySensor->addSensorEvent($airHumidityEventTurnOnRelation);
        $airHumiditySensor->addSensorEvent($airHumidityEventTurnOffRelation);

        $manager->persist($airHumiditySensor);

        $soilMoistureSensor = new SensorType();
        $soilMoistureSensor->setName('SOIL_MOISTURE');
        $soilMoistureSensor->setCanChangeTreshold(true);
        $soilMoistureSensor->setCanControllStartStop(true);
        $soilMoistureSensor->setLabel('Umidade do Solo');
        $soilMoistureSensor->setModel('SENSOR-SOIL-HUM-001');
        $soilMoistureSensor->setUnit('%');

        $soilMoistureEventMeasureRelation = new SensorEvent();
        $soilMoistureEventMeasureRelation->setEvent($sensorMeasureEvent);
        $soilMoistureEventMeasureRelation->setSensorType($soilMoistureSensor);

        $soilMoistureEventTresholdChangeRelation = new SensorEvent();
        $soilMoistureEventTresholdChangeRelation->setEvent($sensorTresholdChangeEvent);
        $soilMoistureEventTresholdChangeRelation->setSensorType($soilMoistureSensor);

        $soilMoistureEventTurnOnRelation = new SensorEvent();
        $soilMoistureEventTurnOnRelation->setEvent($sensorTurnOnEvent);
        $soilMoistureEventTurnOnRelation->setSensorType($soilMoistureSensor);

        $soilMoistureEventTurnOffRelation = new SensorEvent();
        $soilMoistureEventTurnOffRelation->setEvent($sensorTurnOffEvent);
        $soilMoistureEventTurnOffRelation->setSensorType($soilMoistureSensor);

        $soilMoistureSensor->addSensorEvent($soilMoistureEventMeasureRelation);
        $soilMoistureSensor->addSensorEvent($soilMoistureEventTresholdChangeRelation);
        $soilMoistureSensor->addSensorEvent($soilMoistureEventTurnOnRelation);
        $soilMoistureSensor->addSensorEvent($soilMoistureEventTurnOffRelation);

        $manager->persist($soilMoistureSensor);

        $rainSensor = new SensorType();
        $rainSensor->setName('RAIN');
        $rainSensor->setCanChangeTreshold(false);
        $rainSensor->setCanControllStartStop(true);
        $rainSensor->setLabel('Chuva');
        $rainSensor->setModel('SENSOR-RAIN-001');

        $rainSensorEventMeasureRelation = new SensorEvent();
        $rainSensorEventMeasureRelation->setEvent($sensorMeasureEvent);
        $rainSensorEventMeasureRelation->setSensorType($rainSensor);

        $rainSensorEventTurnOnRelation = new SensorEvent();
        $rainSensorEventTurnOnRelation->setEvent($sensorTurnOnEvent);
        $rainSensorEventTurnOnRelation->setSensorType($rainSensor);

        $rainSensorEventTurnOffRelation = new SensorEvent();
        $rainSensorEventTurnOffRelation->setEvent($sensorTurnOffEvent);
        $rainSensorEventTurnOffRelation->setSensorType($rainSensor);

        $rainSensor->addSensorEvent($rainSensorEventMeasureRelation);
        $rainSensor->addSensorEvent($rainSensorEventTurnOnRelation);
        $rainSensor->addSensorEvent($rainSensorEventTurnOffRelation);

        $manager->persist($rainSensor);

        $manager->flush();
    }
}