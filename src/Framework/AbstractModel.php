<?php

namespace CoopertalseAPI\Framework;

use JsonSerializable;

abstract class AbstractModel implements JsonSerializable {

	public abstract function toArray(): array;

	public abstract function getId(): int;

	public abstract static function createFromArray(array $aElement): AbstractModel;

	public function jsonSerialize(): mixed {
		return json_encode($this->toArray());
	}

	public function __toString(): string {
		return $this->jsonSerialize();
	}
}
