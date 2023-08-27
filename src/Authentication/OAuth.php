<?php

namespace OneCRM\APIClient\Authentication;

use OneCRM\APIClient;

/**
 * OAuth2 authentication scheme
 */
class OAuth implements APIClient\Authentication
{
    /**
     * @param  array<string, mixed>  $token access token
     */
    public function __construct(protected array $token)
    {
        //
    }

    public function applyRequestOptions(array &$options): void
    {
        if (! isset($options['headers'])) {
            $options['headers'] = [];
        }
        $options['headers']['Authorization'] = 'Bearer '.$this->token['access_token'];
    }
}
