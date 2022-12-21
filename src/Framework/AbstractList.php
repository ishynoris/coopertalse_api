<?php

namespace CoopertalseAPI\Framework;

use Countable;
use Exception;
use Iterator;

abstract class AbstractList implements Countable, Iterator {

	private int $iIndice = 0;
	protected array $aChaves = [];
	protected array $aElements = [];

	protected function attach(AbstractModel $oElement, $sChave = null) {
		if (empty($sChave)) {
			$sChave = $oElement->getId();
		}
		$this->aChaves[] = $sChave;
		$this->aElements[$sChave] = $oElement;
	}

	public function count(): int {
		return count($this->aElements);
	}

	public function current() {
		$sChave = $this->key();
		return $this->aElements[$sChave];
	}

	public function next(): void {
		$this->iIndice++;
	}

	public function key(): mixed {
		return $this->aChaves[$this->iIndice] ?? null;
	}

	public function valid(): bool {
		$sChave = $this->key();
		if (is_null($sChave)) {
			return false;
		}
		return isset($this->aElements[$sChave]);
	}

	public function rewind(): void {
		$this->iIndice = 0;
	}

	public function getByChave(string $sChave): AbstractModel {
		if ($this->isEmpty()) {
			throw new Exception("Essa lista não possui elementos");
		}

		if (empty($sChave)) {
			throw new Exception("A chave do elemento não foi informada.");
		}

		$oElement = $this->aElements[$sChave];
		if (empty($oElement)) {
			throw new Exception("Nenhum elemento encontrado com a chave \"{$sChave}\"");
		}
		return $oElement;
	}

	public function getByIndice(int $iIndice): AbstractModel {
		if ($iIndice < 0 || $iIndice >= count($this->aChaves)) {
			throw new Exception("Índice \"{$iIndice}\" inválido");
		}

		$sChave = $this->aChaves[$iIndice] ?? "";
		return $this->getByChave($sChave);
	}

	public function first(): AbstractModel {
		$sChave = $this->aChaves[0] ?? "";
		return $this->getByChave($sChave);
	}

	public function last(): AbstractModel {
		$iTotal = count($this->aChaves);
		$sChave = $this->aChaves[$iTotal - 1] ?? "";
		return $this->getByChave($sChave);
	}

	public function isEmpty(): bool {
		return $this->count() == 0;
	}
}