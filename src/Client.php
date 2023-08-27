<?php

namespace OneCRM\APIClient;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;

/**
 * API Client
 */
class Client
{
    protected Calendar $_calendar;

    protected Files $_files;

    /**
     * Constructor
     *
     * @param  string  $url URL of API entry point, including api.php, ex. https://demo.1crmcloud.com/api.php
     * @param  Authentication|null  $auth Optional instance of Authentication
     */
    public function __construct(protected string $url, protected ?Authentication $auth = null)
    {
        $this->url = rtrim($url, '/').'/';
    }

    /**
     * Sets authentication used for all subsequent API requests
     */
    public function setAuth(Authentication $auth): void
    {
        $this->auth = $auth;
    }

    /**
     * Sends a request to API
     *
     * This method is used to send an arbitrary request to 1CRM REST API.
     *
     * @param  string  $method HTTP request method (GET, PUT, POST, etc.)
     * @param  string  $endpoint API endpoint, relative to API URL (ex. /data/Account)
     * @param  array<string, mixed>  $options Request options. Can be any options accepted by GuzzleHttp\Client
     * @return mixed Decoded response from API
     *
     * @throws Error
     */
    public function request(string $method, string $endpoint, array $options = []): mixed
    {
        try {
            $endpoint = ltrim($endpoint, '/');
            $this->auth?->applyRequestOptions($options);
            $skip_body_parsing = ! empty($options['skip_body_parsing']);
            unset($options['skip_body_parsing']);
            $options['base_uri'] = $this->url;
            $options['http_errors'] = false;
            $client = new \GuzzleHttp\Client($options);
            $response = $client->request($method, $endpoint);
            $status = $response->getStatusCode();
            $body = $response->getBody();
            if (! in_array($status, [200, 201, 202, 203, 204])) {
                try {
                    $json = json_decode((string) $body, true, 512, JSON_THROW_ON_ERROR);
                    throw Error::fromAPIResponse($status, $json);
                } catch (JsonException) {
                    throw new Error('Unexpected reply from server', 500);
                }
            }
            if ($skip_body_parsing) {
                return $body;
            }
            try {
                $json = json_decode((string) $body, true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException) {
                throw new Error('Unexpected reply from server', 500);
            }

            return $json;
        } catch (GuzzleException $e) {
            throw new Error($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Sends a POST request to API
     *
     * @param  string  $endpoint API endpoint, relative to API URL (ex. /data/Account)
     * @param  array<string, mixed>  $body Request body. Must be an array, it will be json-encoded
     * @param  array<string, mixed>  $query_params Array with query params appended to the URL ( ex. ['offset' => 20]). Normally, this is not used
     * @return mixed Decoded response from API
     *
     * @throws Error
     */
    public function post(string $endpoint, array $body, array $query_params = []): mixed
    {
        return $this->request('POST', $endpoint, ['json' => $body, 'query' => $query_params]);
    }

    /**
     * Sends a PATCH request to API
     *
     * @param  string  $endpoint API endpoint, relative to API URL (ex. /data/Account/1234)
     * @param  array<string, mixed>  $body Request body. Must be an array, it will be json-encoded
     * @param  array<string, mixed>  $query_params Array with query params appended to the URL ( ex. ['offset' => 20]). Normally, this is not used
     * @return mixed Decoded response from API
     *
     * @throws Error
     */
    public function patch(string $endpoint, array $body, array $query_params = []): mixed
    {
        return $this->request('PATCH', $endpoint, ['json' => $body, 'query' => $query_params]);
    }

    /**
     * Sends a PUT request to API
     *
     * @param  string  $endpoint API endpoint, relative to API URL
     * @param  array<string, mixed>  $body Request body. Must be an array, it will be json-encoded
     * @param  array<string, mixed>  $query_params Array with query params appended to the URL ( ex. ['offset' => 20]). Normally, this is not used
     * @return array<string, mixed> Decoded response from API
     *
     * @throws Error
     */
    public function put(string $endpoint, array $body, array $query_params = []): array
    {
        return $this->request('PUT', $endpoint, ['json' => $body, 'query' => $query_params]);
    }

    /**
     * Sends a GET request to API
     *
     * @param  string  $endpoint API endpoint, relative to API URL  (ex. /data/Account)
     * @param  array<string, mixed>  $query_params Array with query params appended to the URL ( ex. ['offset' => 20])
     * @return mixed Decoded response from API
     *
     * @throws Error
     */
    public function get(string $endpoint, array $query_params = []): mixed
    {
        return $this->request('GET', $endpoint, ['query' => $query_params]);
    }

    /**
     * Sends a DELETE request to API
     *
     * @param  string  $endpoint API endpoint, relative to API URL  (ex. /data/Account)
     * @param  array<string, mixed>  $query_params Array with query params appended to the URL ( ex. ['offset' => 20])
     * @return array<string, mixed> Decoded response from API
     *
     * @throws Error
     */
    public function delete(string $endpoint, array $query_params = []): array
    {
        return $this->request('DELETE', $endpoint, ['query' => $query_params]);
    }

    /**
     * Creates an instance of Model class to work with data stored in
     * 1CRM database.
     *
     * @param  string  $model_name Model name, ex. Account
     */
    public function model(string $model_name): Model
    {
        return new Model($this, $model_name);
    }

    /**
     * Creates an instance of Calendar class to work with events data.
     */
    public function calendar(): Calendar
    {
        if (! isset($this->_calendar)) {
            $this->_calendar = new Calendar($this);
        }

        return $this->_calendar;
    }

    /**
     * Creates an instance of Files class to upload and download files.
     */
    public function files(): Files
    {
        if (! isset($this->_files)) {
            $this->_files = new Files($this);
        }

        return $this->_files;
    }

    /**
     * Returns information about authenticated user.
     *
     * @return array<string, mixed>
     *
     * @throws Error
     */
    public function me(): array
    {
        return $this->get('/me');
    }

    /**
     * Returns API server's public key.
     *
     * @throws Error
     */
    public function serverKey(): string
    {
        $result = $this->get('/public_key');

        return $result['key'];
    }

    /**
     * Returns information server software version.
     *
     * @return array<string, mixed>
     * @throws Error
     */
    public function serverVersion(): array
    {
        return $this->get('/version');
    }
}
