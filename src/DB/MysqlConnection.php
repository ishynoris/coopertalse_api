<?php
namespace CoopertalseAPI\DB;

use PDO;
use PDOException;

use CoopertalseAPI\DB\ConnectionInterface;

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
			echo "Falha: " . $e->getMessage() . "\n";
			die();
		}
	}

	public function insert(string $sSql, array $aParams = []): int {
		$stmt = $this->oPDO->prepare($sSql);
		$stmt->execute($aParams);
		return $this->oPDO->lastInsertId();
	}

	public function select(string $sSql, array $aParams = []): array {
		$oStatement = $this->oPDO->prepare($sSql);
		$oStatement->execute($aParams);
		return $oStatement->fetchAll();
	}

	public function selectOne(string $sSql, array $aParams = []): array {
		$oStatement = $this->oPDO->prepare($sSql);
		$oStatement->execute($aParams);
		return $oStatement->fetch();
	}

	public function execute(string $sSql, array $aParams = []): int {
		$oStatement = $this->oPDO->prepare($sSql);
		$oStatement->execute($aParams);
		return $oStatement->rowCount();
	}
}
