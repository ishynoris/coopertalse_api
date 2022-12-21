<?php 

namespace CoopertalseAPI\Motorista;

use CoopertalseAPI\Carro\Carro;
use CoopertalseAPI\ChavePix\ChavePix;
use CoopertalseAPI\ChavePix\ChavePixList;
use CoopertalseAPI\Framework\AbstractModel;
use CoopertalseAPI\Framework\DC;
use Psr\Http\Message\ServerRequestInterface as Request;

class Motorista extends AbstractModel {

	private int $iId = 0;
	private string $sDeviceHash;
	private string $sNome;
	private ChavePixList $loChavePix;
	private Carro $oCarro; 

	public function __construct(string $sNome, string $sDeviceHash, Carro $oCarro) {
		$this->sNome = $sNome;
		$this->sDeviceHash = $sDeviceHash;
		$this->oCarro = $oCarro;
		$this->loChavePix = new ChavePixList;
	}

	public static function createFromArray(array $aMotorista): Motorista {
		$oCarro = Carro::createFromArray($aMotorista);
		$oMotorista = new Motorista($aMotorista['mta_nome'], $aMotorista['mta_device_hash'], $oCarro);

		if (isset($aMotorista['mta_id'])) {
			$oMotorista->iId = $aMotorista['mta_id'];
		}

		$aaChaves = $aMotorista['chx_chave_pix'] ?? [];
		foreach ($aaChaves as $aChave) {
			$aChave['oMotorista'] = $oMotorista;
			$oChave = ChavePix::createFromArray($aChave);
			$oMotorista->addChavePix($oChave);
		}

		return $oMotorista;
	}

	public static function createFromRequest(Request $oRequest): Motorista {
		$aMotorista = json_decode($oRequest->getBody()->getContents(), true);
		return self::createFromArray($aMotorista);
	}

	public function toArray(): array {
		return [
			'mta_id' => $this->iId,
			'mta_device_hash' => $this->sDeviceHash,
			'mta_nome' => $this->sNome,
			'cro_id' => $this->getCarroId(),
			'cro_numero' => $this->oCarro->getNumero(),
		];
	}

	public function addChavePix(ChavePix $oChavePix) {
		$this->loChavePix->add($oChavePix);
	}

	public function getId(): int {
		return $this->iId ?? 0;
	}

	public function setId(int $iId) {
		$this->iId = $iId;
	}

	public function getDeviceHash(): string {
		return $this->sDeviceHash;
	}

	public function getNome(): string {
		return $this->sNome;
	}

	public function getNumeroCarro(): string {
		return $this->oCarro->getNumero();
	}

	public function getCarroId(): int {
		return $this->oCarro->getId();
	}

	public function cadastrar() {
		$this->oCarro->cadastrar();
		DC::getMotoristaDAO()->save($this);

		/** @var ChavePix $oChavePix */
		foreach ($this->loChavePix as $oChavePix) {
			$oChavePix->cadastrar();
		}
	}

	public function copyFrom(Motorista $oMotorista) {
		$this->sDeviceHash = $oMotorista->sDeviceHash ?? $this->sDeviceHash;
		$this->sNome = $oMotorista->sNome ?? $this->sNome;
		$this->oCarro->copyFrom($oMotorista->oCarro);		
	}

	public function atualizar() {
		DC::getMotoristaDAO()->replace($this);
	}
}
