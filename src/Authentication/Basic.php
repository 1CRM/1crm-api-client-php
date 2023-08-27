<?php

namespace OneCRM\APIClient\Authentication;

use OneCRM\APIClient;

/**
 * Basic authentication scheme
 */
class Basic implements APIClient\Authentication
{
    /**
     * @param $username 1CRM user name
     * @param $password User's password
     */
    public function __construct(protected string $username, protected string $password)
    {
        //
    }

    public function applyRequestOptions(array &$options): void
    {
        $options['auth'] = [$this->username, $this->password];
    }
}
