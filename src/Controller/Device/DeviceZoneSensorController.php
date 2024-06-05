<?php 
namespace App\Controller\Device;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Application\Device\DTOs\NewSensorZoneDeviceDTO;
use App\Application\Device\Services\AddSensorToZoneDeviceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeviceZoneSensorController extends AbstractController
{
    #[Route('/device/zone/sensor', name: 'add_sensor_to_zone', methods: ['POST'])]
    public function addNewSensor(
        Request $request,
        AddSensorToZoneDeviceService $addNewZoneToDeviceService
    ): Response
    {
        $json = $request->getContent();
        $payload = json_decode($json);

        if(is_null($payload))
        {
            return $this->json(
                data: [
                    'message' => 'Payload is empty, please check the request body and try again.'
                ], 
                status: 422
            );
        }

        $newSensorDTO = new NewSensorZoneDeviceDTO(
            macAddress: $payload->macAddress,
            alias: $payload->alias ?? null,
            zonePosition: $payload->zonePosition,
            sensorModelId: $payload->sensorModelId
        );

        $addNewZoneToDeviceService->execute($newSensorDTO);

        return $this->json(
            data: [
                'message' => 'Sensor successfully created and added to the devices zone.',
            ],
            status: 201
        );    
    }   
}