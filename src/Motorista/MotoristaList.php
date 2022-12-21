<?php 

namespace CoopertalseAPI\Motorista;

use CoopertalseAPI\Framework\AbstractList;

class MotoristaList extends AbstractList {

	public function add(Motorista $oMotorista) {
		$this->attach($oMotorista);
	}

	public static function createFromArray(array $aaMotorista): MotoristaList {
		return array_reduce($aaMotorista, function(MotoristaList $loMotorista, array $aMotorista) {
			$loMotorista->add(Motorista::createFromArray($aMotorista));
			return $loMotorista;
		}, new MotoristaList);
	}
}
