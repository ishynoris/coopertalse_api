<?php 

namespace CoopertalseAPI\Dispositivo;

use CoopertalseAPI\Framework\DC;
use CoopertalseAPI\Motorista\MotoristaFilters;
use Exception;
use Psr\Http\Message\ResponseInterface as Resp;
use Psr\Http\Message\ServerRequestInterface as Req;
use Slim\App;

class DispositivoAPI {

	public function __invoke(App $oGroup) {
		$oGroup->group("/{_hash_dispositivo}", function(App $oGroup) {
			$oGroup->get("/motorista", [ self::class, "consultarMotoristaPorDispositivo" ]);
		});
	}

	public static function consultarMotoristaPorDispositivo(Req $oRequest, Resp $oResponse, array $aArgs): Resp {
		$sHash = $aArgs['_hash_dispositivo'] ?? "";
		if (empty($sHash)) {
			throw new Exception("Nenhumm hash de dispositivo informado");
		}

		$oMotoristaFilters = new MotoristaFilters;
		$oMotoristaFilters->setHashDispositivo([ $sHash ]);
		$loMotoristas = DC::getMotoristaDAO()->findByFilters($oMotoristaFilters);
		if ($loMotoristas->isEmpty()) {
			throw new Exception("Nenhum motorista encontrado para o dispositivo {$sHash}");
		}

		$oMotorista = $loMotoristas->first();
		$oResponse->getBody()->write($oMotorista->__toString());
		return $oResponse;
	}
}
