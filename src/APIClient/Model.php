<?php

namespace OneCRM\APIClient;

/**
 * Used to work wit 1CRM data
 */
class Model {

    protected $client;
    protected $model_name;

    public function __construct(Client $client, $model_name) {
        $this->client = $client;
        $this->model_name = $model_name;
    }

    /**
     * Get list of records.
     * 
     * @param $options array with request options
     *      * `fields`: optional array with fields you want returned
     *      * `filters`: optional associative array with filters. Keys are filter names, values are filter values
     *      * `order`: optional sort order
     *      * `query_favorite`: optional boolean, if true, results will include `is_favorite` flag
     *      * `filter_text`: optional filter text, used for generic text search
     * @param $offset Starting offset
     * @param $limit Maximum number of records to return
     * 
     */
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

    /**
     * Get list of related records.
     * 
     * @param $id ID of parent record
     * @param $link Link name
     * @param $options array with request options
     *      * `fields`: optional array with fields you want returned
     *      * `filters`: optional associative array with filters. Keys are filter names, values are filter values
     *      * `order`: optional sort order
     *      * `filter_text`: optional filter text, used for generic text search
     * @param $offset Starting offset
     * @param $limit Maximum number of records to return
     * 
     */
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

    /**
     * 
     * Adds a related record
     * 
     * `$data` parameter can be in different forms:
     *      * string with related record ID. Specified related record will be added to parent record via specified link
     *      * array with related record IDs. Specified related records will be added to parent record via specified link
     *      * associative array with keys containing related record IDs and values containing additional data:
     *
     * ~~~~~~~~~~~~~{.php}
     * //
     * $data = [
     *      3d3e96d1-8d7c-acd6-e338-55b9b0cc5aae" => ["quantity" => 5]
     * ];
     * //
     * ~~~~~~~~~~~~~
     * 
     * 
     * @param $id ID of parent record
     * @param $link Link name
     * @param $data Related data
     */
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
        $result = $this->client->post($endpoint, $body);
        return $result['result'];
    }

    /**
     * Retrieves single record with specified ID
     * 
     * @param $id Record ID
     * @param $fields List of fields to fetch
     */
    public function get($id, array $fields = []) {
        $endpoint = '/data/' . $this->model_name . '/' . $id;
        $query = ['fields' => $fields];
        $result = $this->client->get($endpoint, $query);
        return $result['record'];
    }

    /**
     * Creates a new record
     * 
     * @param $data Associative array with record data. Keys are field names, values are field values.
     * 
     * @return New record ID
     */
    public function create($data) {
        $endpoint = '/data/' . $this->model_name;
        $body = ['data' => $data];
        $result = $this->client->post($endpoint, $body);
        return $result['id'];
    }

    /**
     * Updates a record
     * 
     * @param $id Record ID
     * @param $data Associative array with record data. Keys are field names, values are field values.
     * @param $create If true, the record will be created if it does not exist
     *
     * @return Always true
     */
    public function update($id, $data, $create = false) {
        $endpoint = '/data/' . $this->model_name . '/' . $id;
        $body = ['data' => $data, 'create' => $create];
        $result = $this->client->patch($endpoint, $body);
        return $result['result'];
    }

    /**
     * Deletes a record
     * 
     * @param $id Record ID
     *
     * @return true if record was deleted
     */
    public function delete($id) {
        $endpoint = '/data/' . $this->model_name . '/' . $id;
        $result = $this->client->delete($endpoint);
        return $result['result'];
    }

    /**
     * Retrieves fields and filters metadata
     * 
     * @return Array with metadata
     */
    public function metadata() {
        $endpoint = '/meta/fields/' . $this->model_name;
        $result = $this->client->get($endpoint);
        return $result;
    }

}