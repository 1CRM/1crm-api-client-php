<?php

namespace OneCRM\APIClient\Authentication;
use OneCRM\APIClient;

/**
 * OAuth2 authentication scheme
 */

class OAuth implements APIClient\Authentication {

	protected $token;

	/**
	 * @param $token access token
	 */
	public function __construct(array $token) {
		$this->token = $token;
	}

	public function applyRequestOptions(array &$options) {
		if (!isset($options['headers']))
			$options['headers'] = [];
		$options['headers']['Authorization'] = 'Bearer ' . $this->token['access_token'];
	}

}

