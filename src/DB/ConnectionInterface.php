<?php

namespace CoopertalseAPI\DB;

interface ConnectionInterface {

	public function insert(string  $sSql, array $aParams = []): int;

	public function select(string  $sSql, array $aParams = []): array;

	public function selectOne(string $sSql, array $aParams = []): array;

	public function execute(string $sSql, array $aParams = []): int;

	public function startTransaction(): bool;

	public function commitTransaction(): bool;

	public function rollbackTransaction(): bool;
}