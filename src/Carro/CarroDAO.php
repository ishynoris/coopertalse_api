<?php 

namespace CoopertalseAPI\Carro;

use CoopertalseAPI\DB\ConnectionInterface;

class CarroDAO {

	private ConnectionInterface $oConnection;

	public function __construct(ConnectionInterface $oConnection) {
		$this->oConnection = $oConnection;
	}

	public function save(Carro $oCarro) {
		$sSql = "INSERT INTO cro_carro (cro_numero) VALUES (?);";
		$aParams = [
			$oCarro->getNumero(),
		];

		$iId = $this->oConnection->insert($sSql, $aParams);
		$oCarro->setId($iId);
	}
}
