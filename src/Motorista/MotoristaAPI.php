<?php 

namespace CoopertalseAPI\Motorista;

use CoopertalseAPI\Framework\DC;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Throwable;

class MotoristaAPI {

	public function __invoke(App $oGroup) {
		$oGroup->post("/", [ self::class, "salvar" ]);
	
		$oGroup->group("/{_id}", function(App $oGroup) {
			$oGroup->post("/atualizar", [ self::class, "atualizar" ]);
		});
	}

	public static function salvar(Request $oRequest, Response $oResponse): Response {
		$oMotorista = Motorista::createFromRequest($oRequest);
		DC::getConnection()->startTransaction();
		try {
			$oMotorista->cadastrar();
		} catch (Throwable $e) {
			DC::getConnection()->rollbackTransaction();
			throw $e;
		} finally {
			DC::getConnection()->commitTransaction();
			$oResponse->getBody()->write($oMotorista->__toString());
		}
		return $oResponse;
	}

	public static function atualizar(Request $oRequest, Response $oResponse, array $aArgs): Response {
		$iId = (int) $aArgs['_id'];
		$oMotorista = DC::getMotoristaDAO()->find($iId);
		$oNovoMotorista = Motorista::createFromRequest($oRequest);
		$oMotorista->copyFrom($oNovoMotorista);
		$oMotorista->atualizar();
		$oResponse->getBody()->write($oMotorista->__toString());
		return $oResponse;
	}
}
