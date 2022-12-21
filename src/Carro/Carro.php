<?php 

namespace CoopertalseAPI\Carro;

use CoopertalseAPI\Framework\AbstractModel;
use CoopertalseAPI\Framework\DC;

class Carro extends AbstractModel {

	private int $iId;
	private string $sNumero;

	public function __construct(string $sNumero) {
		$this->sNumero = $sNumero;
	}

	public static function createFromArray(array $aElement): AbstractModel {
		$oCarro = new Carro($aElement['cro_numero']);
		if (!empty($aElement['cro_id'])) {
			$oCarro->iId = $aElement['cro_id'];
		}
		return $oCarro;
	}

	public function toArray(): array {
		return [
			'cro_id' => $this->iId,
            'cro_numero' => $this->sNumero,
		];
	}

	public function setId(int $iId) {
		$this->iId = $iId;
	}

	public function getId(): int {
		return $this->iId ?? 0;
	}

	public function getNumero(): string {
		return str_pad($this->sNumero, 3, "0", STR_PAD_LEFT);
	}

	public function cadastrar() {
		DC::getCarroDAO()->save($this);
	}
}
