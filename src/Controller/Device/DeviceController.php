<?php 
namespace App\Controller\Device;

use App\Application\Device\DTOs\NewDeviceDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Application\Device\Services\CreateNewDeviceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeviceController extends AbstractController
{
    #[Route('/device', name: 'create_device', methods: ['POST'])]
    public function createDevice(
        Request $request,
        CreateNewDeviceService $createNewDeviceService
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

        $newDeviceDTO = new NewDeviceDTO(
            modelId: $payload->modelId,
            macAddress: $payload->macAddress
        );

        $device = $createNewDeviceService->execute($newDeviceDTO);

        return $this->json(
            data: [
                'message' => 'Device successfully created.',
                'device' => $device
            ],
            status: 201
        );    
    }   
}