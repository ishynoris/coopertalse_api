<?php 

namespace CoopertalseAPI\Carro;

use CoopertalseAPI\DB\ConnectionInterface;
use DateTime;

class CarroDAO {

	private ConnectionInterface $oConnection;

	public function __construct(ConnectionInterface $oConnection) {
		$this->oConnection = $oConnection;
	}

	public function save(Carro $oCarro) {
		$sSql = "INSERT INTO cro_carro (cro_numero, cro_data_cadastro, cro_deletado) VALUES (?, ?, ?);";
		$aParams = [
			$oCarro->getNumero(),
			(new DateTime)->format("Y-m-d H:i:s"),
			false,
		];

		$iId = $this->oConnection->insert($sSql, $aParams);
		$oCarro->setId($iId);
	}
}
