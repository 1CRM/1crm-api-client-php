<?php

namespace OneCRM\APIClient;

interface Authorization {
	public function applyRequestOptions(array &$options);
}

