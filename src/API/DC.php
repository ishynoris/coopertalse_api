<?php 

namespace CoopertalseAPI\API;

use CoopertalseAPI\Framework\CoopertalseException;
use Slim\Http\Request as Req;
use Slim\Http\Response as Resp;
use Slim\Container;
use Throwable;

final class DC {

	private static Container $oContainer;

	public static function processErroHandler(Throwable $e, Req $oReq, Resp $oReps): Resp {
		$fnHandler = self::getContainer()->get("errorHandler");
		return $fnHandler($oReq, $oReps, $e);
	}

	public static function getContainer(): Container {
		if (!empty(self::$oContainer)) {
			return self::$oContainer;
		}

		self::$oContainer = new Container();
		self::$oContainer['errorHandler'] = self::getExceptionHandler();
		self::$oContainer['phpErrorHandler'] = self::getExceptionHandler();
		self::$oContainer['notFoundHandler'] = self::getNotFoundHandler();
		self::$oContainer['notAllowedHandler'] = self::getNotAlowedHandler();
		return self::$oContainer;
	}

	private static function getExceptionHandler(): callable {
		$fnHandler = function(Req $oReq, Resp $oResponse, Throwable $e) {
			$sMensagem = $e instanceof CoopertalseException
				? $e->getMessage()
				: "Ocorreu um erro ao processar a requisição";
			$oResponse = $oResponse->withStatus(500);
			$oResponse->getBody()->write($sMensagem);
			return $oResponse;
		};

		return function(Container $oContainer) use ($fnHandler) {
			return $fnHandler;
		};
	}

	private static function getNotFoundHandler(): callable {
		$fnHandler = function(Req $oReq, Resp $oResponse, $e) {
			return $oResponse->withStatus(404);
		};

		return function(Container $oContainer) use ($fnHandler) {
			return $fnHandler;
		};
	}

	private static function getNotAlowedHandler(): callable {
		$fnHandler = function(Req $oReq, Resp $oResponse, array $aAllowedMethods) {
			return $oResponse->withStatus(401);
		};

		return function(Container $oContainer) use ($fnHandler) {
			return $fnHandler;
		};
	}
}
