<?php 

namespace CoopertalseAPI\Motorista;

class MotoristaFilters {

    private string $sHashDispositivo;

    public function getHashDispositivo(): ?string {
        return $this->sHashDispositivo;
    }

    public function setHashDispositivo(string $sHashDispositivo) {
        $this->sHashDispositivo = $sHashDispositivo;
    }
}
