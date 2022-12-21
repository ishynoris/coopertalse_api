<?php

namespace CoopertalseAPI\DB;

interface ConnectionInterface {

    public function insert(string  $sSql, array $aParams = []): int;
}