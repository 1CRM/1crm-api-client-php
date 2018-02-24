<?php

namespace OneCRM\APIClient;

/**
 * Implementation of OAUth2 flow
 */
class AuthorizationFlow {

    protected $url;
    protected $options;

    /**
     * 
     * Constructor.
     * 
     * Flow parameters passed in $options depend on authorization flow used:
     *      * `client_id`: API client ID. Required. Can be omited if `ONECRM_CLIENT_ID` environment variable is set.
     *      * `client_secret`: API client secret. Required.  Can be omited if `ONECRM_CLIENT_SECRET` environment variable is set.
     *      * `redirect_uri`: Redirect URI. Required for Authorization Code flow.  Can be omited if `ONECRM_REDIRECT_URI` environment variable is set.
     *      * `username`: 1CRM user name. Required for Resource Owner Password Credentials flow.  Can be omited if `ONECRM_USERNAME` environment variable is set.
     *      * `password`: 1CRM user password. Required for Resource Owner Password Credentials flow.  Can be omited if `ONECRM_PASSWORD` environment variable is set.
     *      * `scope`: Authorization request scope. Optional, defaults to `profile`
     *      * `owner_type`: `user` or `contact`. Default value is `user`
     *      * `state`: CSRF token. Optional
     * 
     * @param $url URL of API entry point, including api.php, ex. https://demo.1crmcloud.com/api.php
     * @param $options Params used by OAuth2 flow
     */
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

    /**
     * Starts OAuth2 flow.
     * 
     * Use this method to start authorization flow and obtain OAuth2 access token.
     * 
     * Valid values for `$grant` parameters are:
     *      * `authorization_code`: starts %Authorization Code Grant flow
     *      * `password`: obtains an access token using Resource Owner Password Credentials Grant flow
     *      * `client_credentials`: obtains an access token using %Client Credentials Grant flow
     *
     * When  `password` or `client_credentials` are used, this method returns an access token directly.
     *
     *  When `authorization_code` is used, this method returns an URI the user must visit to complete
     * the authorization flow. Additionally, you can pass `true` in `$auto_redirect` to automatically
     * send `Location:` header for redirect.
     * 
     * @throws Error
     */
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

    /**
     * Finalizes Oauth2 %Authorization Code Grant flow
     * 
     * This method must be called when user returns to `redirect_url` after granting
     * access to the application. 
     * 
     * @param $response Normally, this can be omited to use parameters passed by 1CRM OAuth server via query string.
     * @return OAuth2 access token
     * @throws Error
     * 
     */
    public function finalize(array $response = null) {
        if (!$response)
            $response = $_GET;
        return $this->finalAuthCode($response);
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

    protected function initResourceOwner() {
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

   protected function initClientCredentials() {
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

    /**
     * Refreshes expired access token
     * 
     * @param $refreshToken Refresh token
     * 
     * @return New access token
     * @throws Error
     */
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