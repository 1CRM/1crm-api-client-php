<?php

namespace OneCRM\APIClient;

class AuthorizationFlow {

    protected $url;
    protected $options;

    public function __construct($url, array $options = []) {
        $this->url = $url;
        $defaults = [
            'client_id' => isset($_ENV['ONECRM_CLIENT_ID']) ? $_ENV['ONECRM_CLIENT_ID'] : null,
            'client_secret' => isset($_ENV['ONECRM_CLIENT_SECRET']) ? $_ENV['ONECRM_CLIENT_SECRET'] : null,
            'redirect_uri' => isset($_ENV['ONECRM_REDIRECT_URI']) ? $_ENV['ONECRM_REDIRECT_URI'] : null,
            'username' => isset($_ENV['ONECRM_USERNAME']) ? $_ENV['ONECRM_USERNAME'] : null,
            'password' => isset($_ENV['ONECRM_PASSWORD']) ? $_ENV['ONECRM_PASSWORD'] : null,
            'scope' => 'profile',
            'owner_type' => 'user',
            'state' => '',
        ];
        foreach($defaults as $k => $v) {
            if (!array_key_exists($k, $options)) {
                $options[$k] = $v;
            }
        }
        $this->options = $options;
    }

    public function init($grant, $auto_redirect = false) {
        switch($grant) {
            case 'authorization_code':
                return $this->initAuthCode($auto_redirect);
                break;
            case 'password':
                return $this->initResourceOwner();
                break;
            case 'client_credentials':
                return $this->initClientCredentials();
                break;
            default:
                throw new Error('Unknown grant type for AuthorizationFlow::init');
        }
    }

    public function finalize($grant, $response = null) {
        if (!$response)
            $response = $_GET;
        switch($grant) {
            case 'authorization_code':
                return $this->finalAuthCode($response);
                break;
            default:
                throw new Error('Unknown grant type for AuthorizationFlow::finalize');
        }
    }

    protected function initAuthCode($auto_redirect) {
        $url = $this->url . '/auth/' . $this->options['owner_type'] . '/authorize';
        $url .= '?' . http_build_query([
            'response_type' => 'code',
            'client_id' => $this->options['client_id'],
            'redirect_uri' => $this->options['redirect_uri'],
            'state' => $this->options['state']
        ]);
        if ($auto_redirect) {
            header('Location: ' . $url);
        }
        return $url;
    }

    protected function validateResponseState($response) {
        if ( (isset($response['state']) ? $response['state'] : null) !== (isset($this->options['state']) ? $this->options['state'] : null) ) {
            throw new Error('Invalid state passed');
        }
    }

    protected function finalAuthCode($response) {
        $this->validateResponseState($response);
        $client = new Client($this->url);
        $body = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->options['client_id'],
            'scope' => $this->options['scope'],
            'client_secret' => $this->options['client_secret'],
            'redirect_uri' => $this->options['redirect_uri'],
            'code' => $response['code']
        ];
        $endpoint = 'auth/' . $this->options['owner_type'] . '/access_token';
        $result = $client->post($endpoint, $body);
        return $result;
    }

    public function initResourceOwner() {
        $endpoint = 'auth/' . $this->options['owner_type'] . '/access_token';
        $body = [
            'grant_type' => 'password',
            'client_id' => $this->options['client_id'],
            'scope' => $this->options['scope'],
            'client_secret' => $this->options['client_secret'],
            'username' => $this->options['username'],
            'password' => $this->options['password'],
        ];
        $client = new Client($this->url);
        $result = $client->post($endpoint, $body);
        return $result;
   }

   public function initClientCredentials() {
        $endpoint = 'auth/' . $this->options['owner_type'] . '/access_token';
        $body = [
            'grant_type' => 'client_credentials',
            'client_id' => $this->options['client_id'],
            'scope' => $this->options['scope'],
            'client_secret' => $this->options['client_secret'],
        ];
        $client = new Client($this->url);
        $result = $client->post($endpoint, $body);
        return $result;
    }

    public function refreshToken($refreshToken) {
        $endpoint = 'auth/' . $this->options['owner_type'] . '/access_token';
        $body = [
            'grant_type' => 'refresh_token',
            'client_id' => $this->options['client_id'],
            'scope' => $this->options['scope'],
            'client_secret' => $this->options['client_secret'],
            'refresh_token' => $refreshToken
        ];
        $client = new Client($this->url);
        $result = $client->post($endpoint, $body);
        return $result;
    }

}