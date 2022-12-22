<?php
namespace CoopertalseAPI\DB;

use PDO;
use PDOException;

use CoopertalseAPI\DB\ConnectionInterface;
use CoopertalseAPI\Framework\CoopertalseException;

class MysqlConnection implements ConnectionInterface {

	private PDO $oPDO;

	public function __construct(string $sHost, string $sDbName, string $sUsusario, string $sSenha = "") {
		try {
			$sStringConexao = sprintf("mysql:host=%s;dbname=%s", $sHost, $sDbName);
			$options = [ PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8' ];

			$this->oPDO = new PDO($sStringConexao, $sUsusario, $sSenha, $options);
			$this->oPDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$this->oPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch (PDOException $e) {
			CoopertalseException::throwFromException("Não foi possível realizar conexão com Banco de Dados", $e);
		}
	}

	public function insert(string $sSql, array $aParams = []): int {
		try {
			$stmt = $this->oPDO->prepare($sSql);
			$stmt->execute($aParams);
		} catch (PDOException $e) {
			CoopertalseException::throwFromException("Não foi possível realizar a inserão no banco", $e);
		}
		return $this->oPDO->lastInsertId();
	}

	public function select(string $sSql, array $aParams = []): array {
		try {
			$oStatement = $this->oPDO->prepare($sSql);
			$oStatement->execute($aParams);
			return $oStatement->fetchAll();
		} catch (PDOException $e) {
			CoopertalseException::throwFromException("Não foi possível realizar a consulta", $e);
		}
	}

	public function selectOne(string $sSql, array $aParams = []): array {
		try {
			$oStatement = $this->oPDO->prepare($sSql);
			$oStatement->execute($aParams);
			return $oStatement->fetch();
		} catch (PDOException $e) {
			CoopertalseException::throwFromException("Não foi possível realizar a consulta unitária", $e);
		}
	}

	public function execute(string $sSql, array $aParams = []): int {
		try {
			$oStatement = $this->oPDO->prepare($sSql);
			$oStatement->execute($aParams);
			return $oStatement->rowCount();
		} catch (PDOException $e) {
			CoopertalseException::throwFromException("Não foi possível executar o script", $e);
		}
	}
}
