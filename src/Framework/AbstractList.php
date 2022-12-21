<?php

namespace CoopertalseAPI\Framework;

use Countable;
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
        $this->aElements[] = $oElement;
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
}