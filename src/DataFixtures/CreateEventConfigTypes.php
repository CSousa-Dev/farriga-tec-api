<?php 
namespace App\DataFixtures;

use App\Infra\Doctrine\Entity\Devices\EventType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

// case IRRIGATOR_ON;
// case IRRIGATOR_OFF;
// case IRRIGATION_STARTED;
// case IRRIGATION_STOPPED;
// case IRRIGATION_CHANGE_WATERING_TIME;
// case IRRIGATION_CHANGE_CHECK_INTERVAL;
// case DEVICE_TURN_ON;
// case DEVICE_TURN_OFF;
// case SENSOR_ON;
// case SENSOR_OFF;
// case SENSOR_MEASURED;
// case SENSOR_TRESHOLD_CHANGE;

class CreateEventConfigTypes extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $eventTypes = [
        //     ['IRRIGATOR_ON',]
        //     'IRRIGATOR_OFF',
        //     'IRRIGATION_STARTED',
        //     'IRRIGATION_STOPPED',
        //     'IRRIGATION_CHANGE_WATERING_TIME',
        //     'IRRIGATION_CHANGE_CHECK_INTERVAL',
        //     'DEVICE_TURN_ON',
        //     'DEVICE_TURN_OFF',
        //     'SENSOR_ON',
        //     'SENSOR_OFF',
        //     'SENSOR_MEASURED',
        //     'SENSOR_TRESHOLD_CHANGE',
        // ];

        // foreach ($eventTypes as $eventType) {
        //     $event = new EventType();
        //     $event->setName($eventType);
        //     $event->setCanEmit(true);
            
        //     $manager->persist($event);
        // }

        $manager->flush();
    }
}