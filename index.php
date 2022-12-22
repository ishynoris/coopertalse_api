<?php

use CoopertalseAPI\API\DC as ApiDC;
use CoopertalseAPI\API\RenderMiddleware;
use CoopertalseAPI\Dispositivo\DispositivoAPI;
use CoopertalseAPI\Motorista\MotoristaAPI;
use Slim\App;

require_once __DIR__ . "/vendor/autoload.php";

$oApp = new App(ApiDC::getContainer());

$oApp->group("/v1", function() {
	$this->group("/motorista", MotoristaAPI::class);
	$this->group("/dispositivo", DispositivoAPI::class);
})->add(RenderMiddleware::class);

$oApp->run();
