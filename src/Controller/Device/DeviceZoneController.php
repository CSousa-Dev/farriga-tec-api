<?php 
namespace App\Controller\Device;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Application\Device\DTOs\NewDeviceZoneDTO;
use App\Controller\Device\Resposes\DeviceResponse;
use App\Application\Device\Services\AddZoneToDeviceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeviceZoneController extends AbstractController
{
    #[Route('/device/zone', name: 'create_device', methods: ['POST'])]
    public function createDevice(
        Request $request,
        AddZoneToDeviceService $addNewZoneToDeviceService
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

        $newDeviceZoneDTO = new NewDeviceZoneDTO(
            macAddress: $payload->macAddress,
            alias: $payload->alias ?? null
        );

        $device = $addNewZoneToDeviceService->execute($newDeviceZoneDTO);

        return $this->json(
            data: [
                'message' => 'Zone successfully created and added to the device.',
                'device' => (new DeviceResponse($device))->toArray()
            ],
            status: 201
        );    
    }   
}