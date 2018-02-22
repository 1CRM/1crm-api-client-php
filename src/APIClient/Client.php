<?php

namespace OneCRM\APIClient;

class Client {

    protected $url;
    protected $auth;
    protected $_calendar;
    protected $_files;

    public function __construct($url, Authorization $auth = null) {
        $this->url = rtrim($url, '/') . '/';
        if ($auth)
            $this->setAuth($auth);
    }

    public function setAuth(Authorization $auth) {
        $this->auth = $auth;
    }

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

    public function post($endpoint, $body, $query_params = []) {
        $options = ['json' => $body, 'query' => $query_params];
        return $this->request('POST', $endpoint, $options);
    }

    public function patch($endpoint, $body, $query_params = []) {
        $options = ['json' => $body, 'query' => $query_params];
        return $this->request('PATCH', $endpoint, $options);
    }

    public function put($endpoint, $body, $query_params = []) {
        $options = ['json' => $body, 'query' => $query_params];
        return $this->request('PUT', $endpoint, $options);
    }

    public function get($endpoint, $query_params = []) {
        $options = ['query' => $query_params];
        return $this->request('GET', $endpoint, $options);
    }

    public function delete($endpoint, $query_params = []) {
        $options = ['query' => $query_params];
        return $this->request('DELETE', $endpoint, $options);
    }

    public function model($model_name) {
        return new Model($this, $model_name);
    }

    public function calendar() {
        if (!$this->_calendar)
            $this->_calendar = new Calendar($this);
        return $this->_calendar;
    }

    public function files() {
        if (!$this->_files)
            $this->_files = new Files($this);
        return $this->_files;
    }

    public function me() {
        return $this->get('/me');
    }

    public function serverKey() {
        $result = $this->get('/public_key');
        return $result['key'];
    }

    public function serverVersion() {
        $result = $this->get('/version');
        return $result;
    }

}
