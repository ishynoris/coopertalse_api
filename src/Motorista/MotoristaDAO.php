<?php 

namespace CoopertalseAPI\Motorista;

use CoopertalseAPI\DB\ConnectionInterface;

class MotoristaDAO {

	private ConnectionInterface $oConnection;

	public function __construct(ConnectionInterface $oConnection) {
		$this->oConnection = $oConnection;
	}

	public function find(int $iId): Motorista {
		$oFiltros = new MotoristaFilters;
		$oFiltros->setId([ $iId ]);
		$loMotoristas = $this->findByFilters($oFiltros);
		return $loMotoristas->first();
	}

	public function findByFilters(MotoristaFilters $oFiltros): MotoristaList {
		$sSql = "SELECT * 
				 FROM mta_motorista mta 
				 JOIN cro_carro cro on mta.cro_id = cro.cro_id
				 WHERE 1=1";
		$aParams = [];

		$aId = $oFiltros->getId();
		if (!empty($aId)) {
			$sBindParams = implode(", ", array_fill(0, count($aId), "?"));
			$sSql .= " AND mta.mta_id IN ({$sBindParams})";
			$aParams = array_merge($aParams, $aId);
		}

		$aHashDispositivo = $oFiltros->getHashDispositivo();
		if (!empty($aHashDispositivo)) {
			$sBindParams = implode(", ", array_fill(0, count($aHashDispositivo), "?"));
			$sSql .= " AND mta.mta_device_hash IN ({$sBindParams})";
			$aParams = array_merge($aParams, $aHashDispositivo);
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

	public function replace(Motorista $oMotorista) {
		$sSql = "UPDATE mta_motorista SET 
					mta_device_hash = ?
					, mta_nome = ?
				 WHERE mta_id = ?";
				 
		$aParams = [
			$oMotorista->getDeviceHash(),
			$oMotorista->getNome(),
			$oMotorista->getId(),
		];

		$this->oConnection->execute($sSql, $aParams);
	}
}
