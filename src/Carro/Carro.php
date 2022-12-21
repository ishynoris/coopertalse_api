<?php 

namespace CoopertalseAPI\Carro;

use CoopertalseAPI\Framework\DC;
use JsonSerializable;

class Carro implements JsonSerializable {

	private int $iId;
	private string $iNumero;

	public function __construct(int $iNumero) {
		$this->iNumero = $iNumero;
	}

	public function __toString(): string {
		return $this->jsonSerialize();
	}

	public function jsonSerialize(): mixed {
		return json_encode([
			'cro_id' => $this->iId,
            'cro_numero' => $this->iNumero,
		]);
	}

	public function setId(int $iId) {
		$this->iId = $iId;
	}

	public function getId(): int {
		return $this->iId ?? 0;
	}

	public function getNumero(): string {
		return str_pad($this->iNumero, 3, "0", STR_PAD_LEFT);
	}

	public function cadastrar() {
		DC::getCarroDAO()->save($this);
	}
}
