<?php

namespace OneCRM\APIClient;

class Files {

    protected $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function upload($res, $filename, $content_type = 'application/octet-stream') {
        $endpoint = '/files/upload';
        $options = [
            'headers' => [
                'Content-Type' => $content_type,
                'X-OneCrm-Filename' => $filename
            ],
            'body' => $res
        ];
        $result = $this->client->request('POST', $endpoint, $options);
        return $result['id'];
    }

    public function download($model, $id) {
        $endpoint = '/files/download/' . $model . '/' . $id;
        $options = [
            'skip_body_parsing' => true
        ];
        return $this->client->request('GET', $endpoint, $options);
    }

    public function info($model, $id) {
        $endpoint = '/files/info/' . $model . '/' . $id;
        return $this->client->get($endpoint);
    }

}

