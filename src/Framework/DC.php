<?php

namespace CoopertalseAPI\Framework;

use CoopertalseAPI\Carro\CarroDAO;
use CoopertalseAPI\ChavePix\ChavePixDAO;
use CoopertalseAPI\DB\ConnectionInterface;
use CoopertalseAPI\DB\MysqlConnection;
use CoopertalseAPI\Motorista\MotoristaDAO;

class DC {

	private static array $aVars;
	private static ConnectionInterface $oConnection;
	private static MotoristaDAO $oMotoristaDAO;
	private static CarroDAO $oCarroDAO;
	private static ChavePixDAO $oChavePixDAO;

	public static function getMotoristaDAO(): MotoristaDAO {
		if (empty(self::$oMotoristaDAO)) {
			$oConnection = self::initConnection();
			self::$oMotoristaDAO = new MotoristaDAO($oConnection);
		}
		return self::$oMotoristaDAO;
	}

	public static function getCarroDAO(): CarroDAO {
		if (empty(self::$oCarroDAO)) {
			$oConnection = self::initConnection();
			self::$oCarroDAO = new CarroDAO($oConnection);
		}
		return self::$oCarroDAO;
	}

	public static function getChavePixDAO(): ChavePixDAO {
		if (empty(self::$oChavePixDAO)) {
			$oConnection = self::initConnection();
			self::$oChavePixDAO = new ChavePixDAO($oConnection);
		}
		return self::$oChavePixDAO;
	}

	private static function initConnection(): ConnectionInterface {
		if (empty(self::$oConnection)) {
			$sDbName = self::getVar("DB_NAME");
			$sHost = self::getVar("HOST");
			$sUsuario = self::getVar("USUARIO");
			$sSenha = self::getVar("SENHA");
			self::$oConnection = new MysqlConnection($sHost, $sDbName, $sUsuario, $sSenha);
		}
		return self::$oConnection;
	}

	public static function getVar(string $sVariavel): ?string {
		if (empty(self::$aVars)) {
			$sArquivo = __DIR__ . "\..\..\\var.json";
			$rConteudo = fopen($sArquivo,  "r");
			$sConteudo = fread($rConteudo, filesize($sArquivo));
			fclose($rConteudo);
			self::$aVars = json_decode($sConteudo, true);
		}
		return self::$aVars[$sVariavel];
	}
}