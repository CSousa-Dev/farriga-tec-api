<?php 
namespace App\Domain\Devices;

interface IRealTimeNotification
{
    public function sendNotification(string $message): void;
}