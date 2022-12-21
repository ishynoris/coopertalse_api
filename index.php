<?php

use CoopertalseAPI\Motorista\MotoristaAPI;
use Slim\Factory\AppFactory;
use Slim\Interfaces\RouteCollectorProxyInterface;

require_once __DIR__ . "/vendor/autoload.php";

$sUrlBase = "/coopertalse_api";

try {
    /** @var Slim\App $oApp */
    $oApp = AppFactory::create();
    $oApp->group($sUrlBase, function(RouteCollectorProxyInterface $oApp) {
        $oApp->group("/motorista", MotoristaAPI::class);
    });
    $oApp->run();
} catch (Exception $e) {
    var_dump($e);
}
