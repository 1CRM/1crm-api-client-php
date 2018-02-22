<?php

namespace OneCRM\APIClient\Authorization;
use OneCRM\APIClient;

class OAuth implements APIClient\Authorization {

	protected $token;

	public function __construct(array $token) {
		$this->token = $token;
	}

	public function applyRequestOptions(array &$options) {
		if (!isset($options['headers']))
			$options['headers'] = [];
		$options['headers']['Authorization'] = 'Bearer ' . $this->token['access_token'];
	}

}

