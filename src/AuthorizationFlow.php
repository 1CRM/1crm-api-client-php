<?php

namespace OneCRM\APIClient;

/**
 * Implementation of OAUth2 flow
 */
class AuthorizationFlow
{
    /**
     * Constructor.
     *
     * Flow parameters passed in $options depend on authorization flow used:
     *      * `client_id`: API client ID. Required. Can be omitted if `ONECRM_CLIENT_ID` environment variable is set.
     *      * `client_secret`: API client secret. Required.  Can be omitted if `ONECRM_CLIENT_SECRET` environment variable is set.
     *      * `redirect_uri`: Redirect URI. Required for Authorization Code flow.  Can be omitted if `ONECRM_REDIRECT_URI` environment variable is set.
     *      * `username`: 1CRM username. Required for Resource Owner Password Credentials flow.  Can be omitted if `ONECRM_USERNAME` environment variable is set.
     *      * `password`: 1CRM user password. Required for Resource Owner Password Credentials flow.  Can be omitted if `ONECRM_PASSWORD` environment variable is set.
     *      * `scope`: Authorization request scope. Optional, defaults to `profile`
     *      * `owner_type`: `user` or `contact`. Default value is `user`
     *      * `state`: CSRF token. Optional
     *
     * @param  string  $url URL of API entry point, including api.php, ex. https://demo.1crmcloud.com/api.php
     * @param  array<string, mixed>  $options Params used by OAuth2 flow
     */
    public function __construct(protected string $url, protected array $options = [])
    {
        $defaults = [
            'client_id' => $_ENV['ONECRM_CLIENT_ID'] ?? null,
            'client_secret' => $_ENV['ONECRM_CLIENT_SECRET'] ?? null,
            'redirect_uri' => $_ENV['ONECRM_REDIRECT_URI'] ?? null,
            'username' => $_ENV['ONECRM_USERNAME'] ?? null,
            'password' => $_ENV['ONECRM_PASSWORD'] ?? null,
            'scope' => 'profile',
            'owner_type' => 'user',
            'state' => '',
        ];
        foreach ($defaults as $k => $v) {
            if (! array_key_exists($k, $options)) {
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
     * When `password` or `client_credentials` are used, this method returns an access token directly.
     *
     * When `authorization_code` is used, this method returns a URI the user must visit to complete
     * the authorization flow. Additionally, you can pass `true` in `$auto_redirect` to automatically
     * send `Location:` header for redirect.
     *
     * @return array<string, mixed>|string
     *
     * @throws Error
     */
    public function init(string $grant, bool $auto_redirect = false): array|string
    {
        switch ($grant) {
            case 'authorization_code':
                return $this->initAuthCode($auto_redirect);
            case 'password':
                return $this->initResourceOwner();
            case 'client_credentials':
                return $this->initClientCredentials();
        }
        throw new Error('Unknown grant type for AuthorizationFlow::init');
    }

    /**
     * Finalizes Oauth2 %Authorization Code Grant flow
     *
     * This method must be called when user returns to `redirect_url` after granting
     * access to the application.
     *
     * @param  array<string, mixed>|null  $response Normally, this can be omitted to use parameters passed by 1CRM OAuth server via query string.
     * @return array<string, mixed> OAuth2 access token
     *
     * @throws Error
     */
    public function finalize(array $response = null): array
    {
        if (! $response) {
            $response = $_GET;
        }

        return $this->finalAuthCode($response);
    }

    protected function initAuthCode(bool $auto_redirect): string
    {
        $url = $this->url.'/auth/'.$this->options['owner_type'].'/authorize';
        $url .= '?'.http_build_query([
            'response_type' => 'code',
            'client_id' => $this->options['client_id'],
            'redirect_uri' => $this->options['redirect_uri'],
            'scope' => $this->options['scope'],
            'state' => $this->options['state'],
        ]);
        if ($auto_redirect) {
            header('Location: '.$url);
        }

        return $url;
    }

    /**
     * @param  array<string, mixed>  $response
     *
     * @throws Error
     */
    protected function validateResponseState(array $response): void
    {
        if (($response['state'] ?? null) !== ($this->options['state'] ?? null)) {
            throw new Error('Invalid state passed');
        }
    }

    /**
     * @param  array<string, mixed>  $response
     * @return array<string, mixed>
     *
     * @throws Error
     */
    protected function finalAuthCode(array $response): array
    {
        $this->validateResponseState($response);
        $body = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->options['client_id'],
            'scope' => $this->options['scope'],
            'client_secret' => $this->options['client_secret'],
            'redirect_uri' => $this->options['redirect_uri'],
            'code' => $response['code'],
        ];
        $endpoint = 'auth/'.$this->options['owner_type'].'/access_token';

        return (new Client($this->url))->post($endpoint, $body);
    }

    /**
     * @return array<string, mixed>
     *
     * @throws Error
     */
    protected function initResourceOwner(): array
    {
        $endpoint = 'auth/'.$this->options['owner_type'].'/access_token';
        $body = [
            'grant_type' => 'password',
            'client_id' => $this->options['client_id'],
            'scope' => $this->options['scope'],
            'client_secret' => $this->options['client_secret'],
            'username' => $this->options['username'],
            'password' => $this->options['password'],
        ];
        return (new Client($this->url))->post($endpoint, $body);
    }

    /**
     * @return array<string, mixed>
     *
     * @throws Error
     */
    protected function initClientCredentials(): array
    {
        $endpoint = 'auth/'.$this->options['owner_type'].'/access_token';
        $body = [
            'grant_type' => 'client_credentials',
            'client_id' => $this->options['client_id'],
            'scope' => $this->options['scope'],
            'client_secret' => $this->options['client_secret'],
        ];
        return (new Client($this->url))->post($endpoint, $body);
    }

    /**
     * Refreshes expired access token.
     *
     * @param  string  $refreshToken Refresh token
     * @return array<string, mixed> New access token
     *
     * @throws Error
     */
    public function refreshToken(string $refreshToken): array
    {
        $endpoint = 'auth/'.$this->options['owner_type'].'/access_token';
        $body = [
            'grant_type' => 'refresh_token',
            'client_id' => $this->options['client_id'],
            'scope' => $this->options['scope'],
            'client_secret' => $this->options['client_secret'],
            'refresh_token' => $refreshToken,
        ];
        return (new Client($this->url))->post($endpoint, $body);
    }
}
