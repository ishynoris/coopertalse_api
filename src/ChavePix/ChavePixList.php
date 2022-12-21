<?php 

namespace CoopertalseAPI\ChavePix;

use CoopertalseAPI\Framework\AbstractList;
use CoopertalseAPI\Motorista\Motorista;

class ChavePixList extends AbstractList {

    public function add(ChavePix $oChave, mixed $sChave = null) {
        if (empty($sChave)) {
            $sChave = $oChave->getId();
        }
        $this->attach($oChave, $sChave);
    }
}
