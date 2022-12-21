<?php 

namespace CoopertalseAPI\Motorista;

class MotoristaFilters {

    private array $aId = [];
    private array $aHashDispositivo = [];

    public function setId(array $aId) {
        $this->aId = $aId;
    }

    public function getId(): array {
        return $this->aId;
    }

    public function getHashDispositivo(): array {
        return $this->aHashDispositivo;
    }

    public function setHashDispositivo(array $aHashDispositivo) {
        $this->aHashDispositivo = $aHashDispositivo;
    }
}
