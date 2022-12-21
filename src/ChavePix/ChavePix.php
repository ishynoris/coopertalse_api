<?php 

namespace CoopertalseAPI\ChavePix;

use CoopertalseAPI\Framework\AbstractModel;
use CoopertalseAPI\Framework\DC;
use CoopertalseAPI\Motorista\Motorista;

class ChavePix extends AbstractModel {

	private int $iId;
	private string $sChave;
    private Motorista $oMotorista;

	public function __construct(string $sChave, Motorista $oMotorista) {
		$this->sChave = $sChave;
        $this->oMotorista = $oMotorista;
	}

	public static function createFromArray(array $aChave): AbstractModel {
		$oChave = new ChavePix($aChave['chx_chave_pix'], $aChave['oMotorista']);

		if (!empty($aChave['chx_id'])) {
			$oChave->iId = $aChave['chx_id'];
		}

		return $oChave;
	}

	public function toArray(): array {
		return [
			'chx_id' => $this->iId,
			'chx_chave_pix' => $this->sChave,
			'mta_id' => $this->oMotorista->getId(),
		];
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
