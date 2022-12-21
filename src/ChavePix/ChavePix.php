<?php 

namespace CoopertalseAPI\ChavePix;

use CoopertalseAPI\Framework\DC;
use CoopertalseAPI\Motorista\Motorista;
use JsonSerializable;

class ChavePix implements JsonSerializable {

	private int $iId;
	private string $sChave;
    private Motorista $oMotorista;

	public function __construct(string $sChave, Motorista $oMotorista) {
		$this->sChave = $sChave;
        $this->oMotorista = $oMotorista;
	}

	public static function createFromArray(array $aChave) {
		return new ChavePix($aChave['chx_id'], $aChave['oMotorista']);
	}


	public function __toString(): string {
		return $this->jsonSerialize();
	}

	public function jsonSerialize(): mixed {
		return json_encode([
			'chx_id' => $this->iId,
            'chx_chave_pix' => $this->sChave,
            'mta_id' => $this->oMotorista->getId(),
		]);
	}

	public function setId(int $iId) {
		$this->iId = $iId;
	}

	public function getId(): int {
		return $this->iId ?? 0;
	}

	public function getMotoristaId(): int {
		return $this->oMotorista->getId();
	}

	public function getChave(): string {
		return $this->sChave;
	}

	public function cadastrar() {
		DC::getChavePixDAO()->save($this);
	}
}
