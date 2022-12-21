<?php 

namespace CoopertalseAPI\ChavePix;

use CoopertalseAPI\DB\ConnectionInterface;

class ChavePixDAO {
	
	private ConnectionInterface $oConnection;

	public function __construct(ConnectionInterface $oConnection) {
		$this->oConnection = $oConnection;
	}

	public function save(ChavePix $oChavePix) {
		$sSql = "INSERT INTO chx_chave_pix (mta_id, chx_chave_pix) VALUES (?, ?);";
		$aParams = [
			$oChavePix->getMotoristaId(),
			$oChavePix->getChave(),
		];

		$iId = $this->oConnection->insert($sSql, $aParams);
		$oChavePix->setId($iId);
	}
}
