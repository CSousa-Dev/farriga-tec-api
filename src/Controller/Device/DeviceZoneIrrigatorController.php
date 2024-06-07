<?php 
namespace App\Controller\Device;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Application\Device\DTOs\NewIrrigatorZoneDeviceDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Device\Services\AddIrrigatorToZoneDeviceService;

class DeviceZoneIrrigatorController extends AbstractController
{
    #[Route('/device/zone/irrigator', name: 'add_irrigator_to_zone', methods: ['POST'])]
    public function addNewIrrigator(
        Request $request,
        AddIrrigatorToZoneDeviceService $addNewZoneToDeviceService
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

        $newIrrigatoDTO = new NewIrrigatorZoneDeviceDTO(
            macAddress: $payload->macAddress,
            alias: $payload->alias ?? null,
            zonePosition: $payload->zonePosition,
            irrigatorModelId: $payload->irrigatorModelId
        );

        $addNewZoneToDeviceService->execute($newIrrigatoDTO);

        return $this->json(
            data: [
                'message' => 'Irrigator successfully created and added to the devices zone.',
            ],
            status: 201
        );    
    }   
}