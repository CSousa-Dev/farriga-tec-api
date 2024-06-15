<?php
namespace App\Controller\Account;

use ListAllUserDevicesService;
use App\Domain\Devices\Device\Device;
use App\Domain\Devices\Device\Zone\Zone;
use App\Domain\Devices\Events\EventConfig;
use App\Domain\Devices\Device\Sensor\Sensor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Domain\Devices\Device\Irrigator\Irrigator;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\Account\Devices\LinkDeviceService;
use App\Application\Account\Devices\UnlinkDeviceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Device\Services\ListAllUserDevicesService as ServicesListAllUserDevicesService;

class AccountDevicesController extends AbstractController
{
    #[Route('/account/device', name: 'link_device', methods: ['POST'])]
    public function linkDevice(
        Request $request, 
        LinkDeviceService $linkDeviceService
    ): JsonResponse
    {   

        $currentUser = $this->getUser();

        if($currentUser === null)
        {
            return $this->json([
                'message' => 'User not found.'
            ], 404);
        }

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

    #[Route('/account/device', name: 'list_devices', methods: ['GET'])]
    public function listDevices(
        ServicesListAllUserDevicesService $listAllUserDevicesService
    )
    {
        $currentUser = $this->getUser();
        $email = $currentUser->getUserIdentifier();

        $devices = $listAllUserDevicesService->execute($email);

        $arrayDevices = [];

        /**
         * @var Device $device
         */
        foreach($devices as $device)
        {
            $arrayZones = [];

            /**
             * @var Zone $zone
             */
            foreach($device->zones() as $zone)
            {
                $arraySensors = [];
                $arrayIrrigators = [];

                /**
                 * @var Sensor $sensor
                 */
                foreach($zone->getSensors() as $sensor)
                {
                    $sensorEvents = $sensor->configuredEvents();

                    $arrayEvents = [];
                    /**
                     * @var EventConfig $event
                     */
                    foreach($sensorEvents as $event)
                    {
                        $arrayEvents[] = [
                            'canEmit' => $event->canEmit,
                            'canNotify' => $event->canListen,
                            'eventName' => $event->eventName,
                            'listenKey' => $event->listenKey,
                            'emitKey' => $event->emitKey
                        ];
                    }

                    $arraySensors[] = [
                        'position' => $sensor->position(),
                        'alias' => $sensor->alias(),
                        'name' => $sensor->name,
                        'model' => $sensor->model,
                        'actions' => [
                            'canChangeTreshold' => $sensor->actionsConfig->canChangeTreshold,
                            'canChangeStartStop' => $sensor->actionsConfig->canControllStartStop,
                            'tresholdType' => $sensor->actionsConfig->tresholdType->toString()
                        ],
                        'configuredEvents' => [
                           ...$arrayEvents
                        ]
                    ];
                }

                /**
                 * @var Irrigator $irrigator
                 */
                foreach($zone->getIrrigators() as $irrigator)
                {

                    $irrigatorEvents = $irrigator->configuredEvents();

                    $arrayEvents = [];
                    /**
                     * @var EventConfig $event
                     */

                    foreach($irrigatorEvents as $event)
                    {
                        $arrayEvents[] = [
                            'canEmit' => $event->canEmit,
                            'canNotify' => $event->canListen,
                            'eventName' => $event->eventName,
                            'listenKey' => $event->listenKey,
                            'emitKey' => $event->emitKey
                        ];
                    }

                    $arrayIrrigators[] = [
                        'position' => $irrigator->position(),
                        'alias' => $irrigator->alias(),
                        'model' => $irrigator->model,
                        'actions' => [
                            'canChangeWateringTime' => $irrigator->actionsConfig->canChangeWateringTime,
                            'canManualControllIrrigation' => $irrigator->actionsConfig->canManualControllIrrigation,
                            'canChangeCheckInterval' => $irrigator->actionsConfig->canChangeCheckInterval,
                            'canTurOnTurnOff' => $irrigator->actionsConfig->canTurOnTurnOff,
                        ],
                        'configuredEvents' => [
                            ...$arrayEvents
                        ]
                    ];
                }

                $arrayZones[] = [
                    'alias' => $zone->alias(),
                    'position' => $zone->position(),
                    'sensors' => $arraySensors,
                    'irrigators' => $arrayIrrigators
                ];
            }

            $arrayEvents = [];

            $deviceEvents = $device->configuredEvents();

            /**
             * @var EventConfig $event
             */

            foreach($deviceEvents as $event)
            {
                $arrayEvents[] = [
                    'canEmit' => $event->canEmit,
                    'canNotify' => $event->canListen,
                    'eventName' => $event->eventName,
                    'listenKey' => $event->listenKey,
                    'emitKey' => $event->emitKey
                ];
            }

            $arrayDevices[] = [
                'macAddress' => $device->macAddress,
                'power' => $device->power(),
                'alias' => $device->alias(),
                'model' => $device->model->model,
                'actions' => [
                    'canPowerControll' => $device->model->canPowerControll,
                    'canManualControll' => $device->model->canManualControll,
                    'useBluetooth' => $device->model->useBluetooth,
                    'useWifi' => $device->model->useWifiConnection,
                ],
                'configuredEvents' => [
                    ...$arrayEvents
                ],
                'zones' => $arrayZones,
            ];
        }

        return $this->json($arrayDevices);
    }
}
