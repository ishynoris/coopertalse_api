<?php

namespace CoopertalseAPI\Framework;

use Exception;
use Throwable;

class CoopertalseException extends Exception {

	public static function throwFromException(string $sMensagem, Throwable $e) {
		throw new CoopertalseException($sMensagem, $e->getCode(), $e);
	}
}
