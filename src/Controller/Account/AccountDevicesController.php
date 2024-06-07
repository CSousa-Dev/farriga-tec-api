<?php
namespace App\Controller\Account;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\Account\Devices\LinkDeviceService;
use App\Application\Account\Devices\UnlinkDeviceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountDevicesController extends AbstractController
{
    #[Route('/account/device', name: 'link_device', methods: ['POST'])]
    public function linkDevice(
        Request $request, 
        LinkDeviceService $linkDeviceService
    ): JsonResponse
    {   
        $currentUser = $this->getUser();
        $email = $currentUser->getUserIdentifier();

        $json = $request->getContent();
        $payload = json_decode($json);

        if(is_null($payload))
        {
            return $this->json([
                'message' => 'Payload is empty, please check the request body and try again.'
            ], 422);
        }

        if($payload->macAddress === null)
        {
            return $this->json([
                'message' => 'Mac address is required.'
            ], 422);
        }

        $linkDeviceService->execute($payload->macAddress, $email);
        
        return $this->json([
            'message' => 'Linked new device successfully.'
        ]);
    }

    #[Route('/account/device', name: 'unlink_device', methods: ['DELETE'])]
    public function unlinkDevice(
        Request $request, 
        UnlinkDeviceService $unlinkDeviceService
    ): JsonResponse
    {
        $currentUser = $this->getUser();
        $email = $currentUser->getUserIdentifier();

        $json = $request->getContent();
        $payload = json_decode($json);

        if(is_null($payload))
        {
            return $this->json([
                'message' => 'Payload is empty, please check the request body and try again.'
            ], 422);
        }

        if($payload->macAddress === null)
        {
            return $this->json([
                'message' => 'Mac address is required.'
            ], 422);
        }

        $unlinkDeviceService->execute($payload->macAddress,$email);

        return $this->json([
            'message' => 'Unlinked device successfully.'
        ]);
    }
}
