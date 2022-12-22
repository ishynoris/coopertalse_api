<?php

use CoopertalseAPI\API\RenderMiddleware;
use CoopertalseAPI\Dispositivo\DispositivoAPI;
use CoopertalseAPI\Motorista\MotoristaAPI;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

require_once __DIR__ . "/vendor/autoload.php";

$oApp = new App();

$oApp->group("/v1", function() {
	$this->get("/test2", function($req, $resp) {
		$resp->withBody(json_encode( [ "dfsdfsdf" ]));
		return $resp;
	});
	$this->group("/motorista", MotoristaAPI::class);
	$this->group("/dispositivo", DispositivoAPI::class);
})->add(RenderMiddleware::class);

$oApp->run();

