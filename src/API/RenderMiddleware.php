<?php

namespace CoopertalseAPI\API;

use Fig\Http\Message\StatusCodeInterface;
use Slim\Psr7\Response;
use Psr\Http\Message\ResponseInterface as Resp;
use Psr\Http\Message\ServerRequestInterface as Req;
use Throwable;
use Traversable;

class RenderMiddleware  {

	public function __invoke(Req $oRequest, Resp $oResponse, callable $oMiddleware) {
		$bSucesso = true;
		$sMensagem = "Sucesso";
		$aResposta = null;

		try {
			$oResponse = $oMiddleware($oRequest, $oResponse);
		} catch (Throwable $e) {
			$oResponse = DC::processErroHandler($e, $oRequest, $oResponse);
			$bSucesso = false;
		}
		
		ob_end_clean();
		$oStream = $oResponse->getBody();
		$oStream->rewind();
		$mResposta = $oStream->getContents();

		if ($bSucesso) {
			$aResposta = $mResposta;
		} else if (is_string($mResposta)) {
			$sMensagem = $mResposta;
		} else {
			$sMensagem = "Ocorreu um erro ao processar a requisição";
			$aResposta = $mResposta;
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