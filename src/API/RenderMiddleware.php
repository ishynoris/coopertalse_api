<?php

namespace CoopertalseAPI\API;

use Fig\Http\Message\StatusCodeInterface;
use Slim\Psr7\Response;
use Psr\Http\Message\ResponseInterface as Resp;
use Psr\Http\Message\ServerRequestInterface as Req;
use Slim\Route;

class RenderMiddleware  {

	public function __invoke(Req $oRequest, Resp $oResponse, Route $oMiddleware) {
		$oResponse = $oMiddleware($oRequest, $oResponse);

		$oStream = $oResponse->getBody();
		$oStream->rewind();
		$aResposta = $oStream->getContents();
		if (empty($aResposta)) {
			$aResposta = [];
		}
	
		$bSucesso = true;
		$sMensagem = "Sucesso";
		if ($oResponse->getStatusCode() != StatusCodeInterface::STATUS_OK) {
			$bSucesso = false;
			$sMensagem = "XPTO";
		}
	
		$sBody = json_encode([
			'sucesso' => $bSucesso,
			'mensagem' => $sMensagem,
			'http_status_code' => $oResponse->getStatusCode(),
			'resposta' => $aResposta,
		], JSON_UNESCAPED_SLASHES);
		$oNovaResposta = new Response($oResponse->getStatusCode());
		$oNovaResposta->getBody()->write($sBody);
		return $oNovaResposta;
	}
}