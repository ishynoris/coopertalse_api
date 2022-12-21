<?php 

namespace CoopertalseAPI\Motorista;

use CoopertalseAPI\DB\ConnectionInterface;

class MotoristaDAO {

	private ConnectionInterface $oConnection;

	public function __construct(ConnectionInterface $oConnection) {
		$this->oConnection = $oConnection;
	}

	public function findByFilters(MotoristaFilters $oFiltros): MotoristaList {
		$sSql = "SELECT * 
				 FROM mta_motorista mta 
				 JOIN cro_carro cro on mta.cro_id = cro.cro_id
				 WHERE 1=1";
		$aParams = [];

		$sHashDispositivo = $oFiltros->getHashDispositivo();
		if (!empty($sHashDispositivo)) {
			$sSql .= " AND mta.mta_device_hash = ?";
			$aParams[] = $sHashDispositivo;
		}

		$aaMotorista = $this->oConnection->select($sSql, $aParams);
		return MotoristaList::createFromArray($aaMotorista);
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
