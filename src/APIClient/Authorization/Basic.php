<?php

namespace OneCRM\APIClient\Authorization;
use OneCRM\APIClient;

class Basic implements APIClient\Authorization {
	
	protected $username;
	protected $password;

	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}

	public function applyRequestOptions(array &$options) {
		$options['auth'] = [$this->username, $this->password];
	}

}

