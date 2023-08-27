<?php

namespace OneCRM\Authentication;

/**
 * %Basic authentication scheme
 */
class Basic implements \OneCRM\Authentication
{
    protected $username;
    protected $password;

    /**
     * @param $username 1CRM user name
     * @param $password User's password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function applyRequestOptions(array &$options)
    {
        $options['auth'] = [$this->username, $this->password];
    }

}
