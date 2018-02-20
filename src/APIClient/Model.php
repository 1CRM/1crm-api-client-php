<?php

namespace OneCRM\APIClient;

class Model {

    private $client;
    private $model_name;

    public function __construct(Client $client, $model_name) {
        $this->client = $client;
        $this->model_name = $model_name;
    }

    public function getList($options = [], $offset = 0, $limit = 0) {
        $endpoint = '/data/' . $this->model_name;
        $query = [];
        if (isset($options['fields']) && is_array($options['fields']))
            $query['fields'] = $options['fields'];
        if (isset($options['filters']) && is_array($options['filters']))
            $query['filters'] = $options['filters'];
        if (isset($options['order']) && is_string($options['order']))
            $query['order'] = $options['order'];
        if (!empty($options['query_favorite']))
            $query['query_favorite'] = 1;
        if (isset($options['filter_text']))
            $query['filter_text'] = $options['filter_text'];
        $query['offset'] = $offset;
        if ($limit > 0)
            $query['limit'] = $limit;
        $result = $this->client->get($endpoint, $query);
        return new ListResult($this->client, $endpoint, $query, $result);
    }

    public function getRelated($id, $link, $options = [], $offset = 0, $limit = 0) {
        $endpoint = '/data/' . $this->model_name . '/' . $id . '/' . $link;
        $query = [];
        if (isset($options['fields']) && is_array($options['fields']))
            $query['fields'] = $options['fields'];
        if (isset($options['filters']) && is_array($options['filters']))
            $query['filters'] = $options['filters'];
        if (isset($options['order']) && is_string($options['order']))
            $query['order'] = $options['order'];
        if (isset($options['filter_text']))
            $query['filter_text'] = $options['filter_text'];
        $query['offset'] = $offset;
        if ($limit > 0)
            $query['limit'] = $limit;
        $result = $this->client->get($endpoint, $query);
        return new ListResult($this->client, $endpoint, $query, $result);
    }

    public function addRelated($id, $link, $data) {
        $endpoint = '/data/' . $this->model_name . '/' . $id . '/' . $link;
        $records = [];
        $records_with_data = [];
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                if (is_array($v)) {
                    $v['id'] = $k;
                    $records_with_data[] = $v;
                } else {
                    $records[] = $v;
                }
            }
        } else if (is_string($data)) {
            $records[] = $data;
        }
        $body = ['records' => $records, 'records_with_data' => $records_with_data];
        var_dump($body);
        $result = $this->client->post($endpoint, $body);
        return $result['result'];
    }

    public function get($id, array $fields = []) {
        $endpoint = '/data/' . $this->model_name . '/' . $id;
        $query = ['fields' => $fields];
        $result = $this->client->get($endpoint, $query);
        return $result['record'];
    }

    public function create($data) {
        $endpoint = '/data/' . $this->model_name;
        $body = ['data' => $data];
        $result = $this->client->post($endpoint, $body);
        return $result['id'];
    }

    public function update($id, $data, $create = false) {
        $endpoint = '/data/' . $this->model_name . '/' . $id;
        $body = ['data' => $data, 'create' => $create];
        $result = $this->client->patch($endpoint, $body);
        return $result['result'];
    }

    public function delete($id) {
        $endpoint = '/data/' . $this->model_name . '/' . $id;
        $result = $this->client->delete($endpoint);
        return $result['result'];
    }

    public function metadata() {
        $endpoint = '/meta/fields/' . $this->model_name;
        $result = $this->client->get($endpoint);
        return $result;
    }

}