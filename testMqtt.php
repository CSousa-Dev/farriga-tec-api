<?php

require_once './vendor/autoload.php';

use App\Infra\MQTTEventManager;

$eventManager = new MQTTEventManager();

$eventManager->configClient();
echo 'Configurando o client';

$eventManager->connect();
echo 'Connectando';

$eventManager->client()->loop(true);
