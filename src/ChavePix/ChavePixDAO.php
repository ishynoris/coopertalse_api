<?php 

namespace CoopertalseAPI\ChavePix;

use CoopertalseAPI\DB\ConnectionInterface;
use DateTime;

class ChavePixDAO {
	
	private ConnectionInterface $oConnection;

	public function __construct(ConnectionInterface $oConnection) {
		$this->oConnection = $oConnection;
	}

	public function save(ChavePix $oChavePix) {
		$sSql = "INSERT INTO chx_chave_pix (mta_id, chx_chave_pix, chx_data_cadastro, chx_deletado) VALUES (?, ?, ?, ?);";
		$aParams = [
			$oChavePix->getMotoristaId(),
			$oChavePix->getChave(),
			(new DateTime)->format("Y-m-d H:i:s"),
			false,
		];

		$iId = $this->oConnection->insert($sSql, $aParams);
		$oChavePix->setId($iId);
	}
}
