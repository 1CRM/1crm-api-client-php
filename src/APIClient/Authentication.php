<?php

namespace OneCRM\APIClient;

/**
 * Authorization scheme interface
 */
interface Authentication {
	/**
	 * Modifies request options to apply authorization scheme
	 */
	public function applyRequestOptions(array &$options);
}

