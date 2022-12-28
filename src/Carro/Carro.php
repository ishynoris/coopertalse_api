<?php 

namespace CoopertalseAPI\Carro;

use CoopertalseAPI\Framework\AbstractModel;
use CoopertalseAPI\Framework\CoopertalseException;
use CoopertalseAPI\Framework\DC;

class Carro extends AbstractModel {

	private int $iId = 0;
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

	public function copyFrom(Carro $oCarro) {
		$this->sNumero = $oCarro->sNumero ?? $this->sNumero;
	}

	public function cadastrar() {
		if (empty($this->sNumero)) {
			throw new CoopertalseException("O número do carro não foi informado");
		}

		DC::getCarroDAO()->save($this);
	}
}
