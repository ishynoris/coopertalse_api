<?php 

namespace CoopertalseAPI\Motorista;

use CoopertalseAPI\DB\ConnectionInterface;

class MotoristaDAO {

	private ConnectionInterface $oConnection;

	public function __construct(ConnectionInterface $oConnection) {
		$this->oConnection = $oConnection;
	}

	public function save(Motorista $oMotorista) {
		$sSql = "INSERT INTO mta_motorista (mta_device_hash, mta_nome, cro_id) 
				 VALUES (?, ?, ?)";
		$aParams = [
			$oMotorista->getDeviceHash(),
			$oMotorista->getNome(),
			$oMotorista->getCarroId(),
		];

		$iId = $this->oConnection->insert($sSql, $aParams);
		$oMotorista->setId($iId);
	}
}
