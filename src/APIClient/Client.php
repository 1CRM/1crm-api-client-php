<?php

namespace OneCRM\APIClient;

/**
 * API Client
 */
class Client {

    protected $url;
    protected $auth;
    protected $_calendar;
    protected $_files;

    /**
     * Constructor
     * 
     * @param $url URL of API entry point, including api.php, ex. https://demo.1crmcloud.com/api.php
     * @param $auth Optional instance of Authentication
     */
    public function __construct($url, Authentication $auth = null) {
        $this->url = rtrim($url, '/') . '/';
        if ($auth)
            $this->setAuth($auth);
    }

    /**
     * Sets authentication used for all subsequent API requests
     */
    public function setAuth(Authentication $auth) {
        $this->auth = $auth;
    }

    /**
     * Sends a request to API
     * 
     * This method is used to send an arbitrary request to 1CRM REST API.
     * 
     * @param $method HTTP request method (GET, PUT, POST, etc.)
     * @param $endpoint API endpoint, relative to API URL (ex. /data/Account)
     * @param $options Request options. Can be any options accepted by GuzzleHttp\Client
     * 
     * @return Decoded response from API
     * @throws Error
     * 
     */
    public function request($method, $endpoint, array $options = []) {
        try {
            $endpoint = ltrim($endpoint, '/');
            if ($this->auth)
                $this->auth->applyRequestOptions($options);
            $skip_body_parsing = !empty($options['skip_body_parsing']);
            unset($options['skip_body_parsing']);
            $options['base_uri'] = $this->url;
            $options['http_errors'] = false;
            $client = new \GuzzleHttp\Client($options);
            $response = $client->request($method, $endpoint);
            $status = $response->getStatusCode();
            $body = $response->getBody();
            if (!in_array($status, range(200, 204))) {
                $json = @json_decode((string)$body, true);
                throw Error::fromAPIResponse($status, $json);                
            }
            if ($skip_body_parsing) {
                return $body;
            }
            $json = @json_decode((string)$body, true);
            if ($json === null) {
                throw new Error('Unexpected reply from server', 500);    
            }
            return $json;
        } catch (\GuzzleHttp\Exception\TransferException $e) {
            throw new Error($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Sends a POST request to API
     * 
     * @param $endpoint API endpoint, relative to API URL (ex. /data/Account)
     * @param $body Request body. Must be an array, it will be json-encoded
     * @param $query Array with query params appended to the URL ( ex. ['offset' => 20]). Normally, this is not used
     * 
     * @return Decoded response from API
     * @throws Error
     * 
     */
    public function post($endpoint, $body, $query_params = []) {
        $options = ['json' => $body, 'query' => $query_params];
        return $this->request('POST', $endpoint, $options);
    }

    /**
     * Sends a PATCH request to API
     * 
     * @param $endpoint API endpoint, relative to API URL (ex. /data/Account/1234)
     * @param $body Request body. Must be an array, it will be json-encoded
     * @param $query Array with query params appended to the URL ( ex. ['offset' => 20]). Normally, this is not used
     * 
     * @return Decoded response from API
     * @throws Error
     * 
     */
    public function patch($endpoint, $body, $query_params = []) {
        $options = ['json' => $body, 'query' => $query_params];
        return $this->request('PATCH', $endpoint, $options);
    }

    /**
     * Sends a PUT request to API
     * 
     * @param $endpoint API endpoint, relative to API URL
     * @param $body Request body. Must be an array, it will be json-encoded
     * @param $query Array with query params appended to the URL ( ex. ['offset' => 20]). Normally, this is not used
     * 
     * @return Decoded response from API
     * @throws Error
     * 
     */
    public function put($endpoint, $body, $query_params = []) {
        $options = ['json' => $body, 'query' => $query_params];
        return $this->request('PUT', $endpoint, $options);
    }

    /**
     * Sends a GET request to API
     * 
     * @param $endpoint API endpoint, relative to API URL  (ex. /data/Account)
     * @param $query Array with query params appended to the URL ( ex. ['offset' => 20])
     * 
     * @return Decoded response from API
     * @throws Error
     * 
     */
    public function get($endpoint, $query_params = []) {
        $options = ['query' => $query_params];
        return $this->request('GET', $endpoint, $options);
    }

    /**
     * Sends a DELETE request to API
     * 
     * @param $endpoint API endpoint, relative to API URL  (ex. /data/Account)
     * @param $query Array with query params appended to the URL ( ex. ['offset' => 20])
     * 
     * @return Decoded response from API
     * @throws Error
     * 
     */
    public function delete($endpoint, $query_params = []) {
        $options = ['query' => $query_params];
        return $this->request('DELETE', $endpoint, $options);
    }

    /**
     * 
     * Creates an instanse of Model class to work with data stored in
     * 1CRM database.
     * 
     * @param $model_name Model name, ex. Account
     * 
     * @return Instance of Model
     * 
     */
    public function model($model_name) {
        return new Model($this, $model_name);
    }

    /**
     * 
     * Creates an instanse of Calendar class to work with events data.
     * 
     * @return Instance of Calendar
     * 
     */
    public function calendar() {
        if (!$this->_calendar)
            $this->_calendar = new Calendar($this);
        return $this->_calendar;
    }

    /**
     * 
     * Creates an instanse of Files class to upload and download files.
     * 
     * @return Instance of Files
     * 
     */
    public function files() {
        if (!$this->_files)
            $this->_files = new Files($this);
        return $this->_files;
    }

    /**
     * Returns information about authenticated user
     */
    public function me() {
        return $this->get('/me');
    }

    /**
     * Returns API server's public key
     */
    public function serverKey() {
        $result = $this->get('/public_key');
        return $result['key'];
    }

    /**
     * Returns information server software version
     */
    public function serverVersion() {
        $result = $this->get('/version');
        return $result;
    }

}
