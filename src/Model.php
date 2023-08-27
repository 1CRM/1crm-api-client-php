<?php

namespace OneCRM\APIClient;

/**
 * Used to work wit 1CRM data
 */
class Model
{
    public function __construct(protected Client $client, protected string $model_name)
    {
        //
    }

    /**
     * Get list of records.
     *
     * @param  array<string, mixed>  $options array with request options
     *      * `fields`: optional array with fields you want returned
     *      * `filters`: optional associative array with filters. Keys are filter names, values are filter values
     *      * `order`: optional sort order
     *      * `query_favorite`: optional boolean, if true, results will include `is_favorite` flag
     *      * `filter_text`: optional filter text, used for generic text search
     * @param  int  $offset Starting offset
     * @param  int  $limit Maximum number of records to return
     *
     * @throws Error
     */
    public function getList(array $options = [], int $offset = 0, int $limit = 0): ListResult
    {
        $endpoint = '/data/'.$this->model_name;
        $query = [];
        if (isset($options['fields']) && is_array($options['fields'])) {
            $query['fields'] = $options['fields'];
        }
        if (isset($options['filters']) && is_array($options['filters'])) {
            $query['filters'] = $options['filters'];
        }
        if (isset($options['order']) && is_string($options['order'])) {
            $query['order'] = $options['order'];
        }
        if (! empty($options['query_favorite'])) {
            $query['query_favorite'] = 1;
        }
        if (isset($options['filter_text'])) {
            $query['filter_text'] = $options['filter_text'];
        }
        $query['offset'] = $offset;
        if ($limit > 0) {
            $query['limit'] = $limit;
        }
        $result = $this->client->get($endpoint, $query);

        return new ListResult($this->client, $endpoint, $query, $result);
    }

    /**
     * Get list of related records.
     *
     * @param  string  $id ID of parent record
     * @param  string  $link Link name
     * @param  array<string, mixed>  $options array with request options
     *      * `fields`: optional array with fields you want returned
     *      * `filters`: optional associative array with filters. Keys are filter names, values are filter values
     *      * `order`: optional sort order
     *      * `filter_text`: optional filter text, used for generic text search
     * @param  int  $offset Starting offset
     * @param  int  $limit Maximum number of records to return
     * @return ListResult
     * @throws Error
     */
    public function getRelated(string $id, string $link, array $options = [], int $offset = 0, int $limit = 0): ListResult
    {
        $endpoint = '/data/'.$this->model_name.'/'.$id.'/'.$link;
        $query = [];
        if (isset($options['fields']) && is_array($options['fields'])) {
            $query['fields'] = $options['fields'];
        }
        if (isset($options['filters']) && is_array($options['filters'])) {
            $query['filters'] = $options['filters'];
        }
        if (isset($options['order']) && is_string($options['order'])) {
            $query['order'] = $options['order'];
        }
        if (isset($options['filter_text'])) {
            $query['filter_text'] = $options['filter_text'];
        }
        $query['offset'] = $offset;
        if ($limit > 0) {
            $query['limit'] = $limit;
        }
        $result = $this->client->get($endpoint, $query);

        return new ListResult($this->client, $endpoint, $query, $result);
    }

    /**
     * Adds a related record.
     *
     * `$data` parameter can be in different forms:
     *      * string with related record ID. Specified related record will be added to parent record via specified link
     *      * array with related record IDs. Specified related records will be added to parent record via specified link
     *      * associative array with keys containing related record IDs and values containing additional data:
     *
     * ~~~~~~~~~~~~~{.php}
     * //
     * $data = [
     *      "3d3e96d1-8d7c-acd6-e338-55b9b0cc5aae" => ["quantity" => 5]
     * ];
     * //
     * ~~~~~~~~~~~~~
     *
     *
     * @param  string  $id ID of parent record
     * @param  string  $link Link name
     * @param  array<string, mixed>|string  $data Related data
     *
     * @throws Error
     */
    public function addRelated(string $id, string $link, array|string $data): string
    {
        $endpoint = '/data/'.$this->model_name.'/'.$id.'/'.$link;
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
        } elseif (is_string($data)) {
            $records[] = $data;
        }
        $body = ['records' => $records, 'records_with_data' => $records_with_data];
        $result = $this->client->post($endpoint, $body);

        return $result['result'];
    }

    /**
     * Removes relationship between records
     *
     * @param  string  $id ID of parent record
     * @param  string  $link Link name
     * @param  string  $rel_id ID of related record to remove
     *
     * @throws Error
     */
    public function deleteRelated(string $id, string $link, string $rel_id): string
    {
        $endpoint = '/data/'.$this->model_name.'/'.$id.'/'.$link.'/'.$rel_id;
        $result = $this->client->delete($endpoint);

        return $result['result'];
    }

    /**
     * Retrieves single record with specified ID.
     *
     * @param  string  $id Record ID
     * @param  array<string>  $fields List of fields to fetch
     * @return array<string, mixed>
     *
     * @throws Error
     */
    public function get(string $id, array $fields = []): array
    {
        $endpoint = '/data/'.$this->model_name.'/'.$id;
        $result = $this->client->get($endpoint, ['fields' => $fields]);

        return $result['record'];
    }

    /**
     * Creates a new record.
     *
     * @param  array<string, mixed>  $data Associative array with record data. Keys are field names, values are field values.
     * @return string|array<string, string> New record ID, or an array of them if there is more than one ID (e.g. when creating a linking record)
     *
     * @throws Error
     */
    public function create(array $data): string|array
    {
        $endpoint = '/data/'.$this->model_name;
        $body = ['data' => $data];
        $result = $this->client->post($endpoint, $body);

        return $result['id'];
    }

    /**
     * Updates a record.
     *
     * @param  string  $id Record ID
     * @param  array<string, mixed>  $data Associative array with record data. Keys are field names, values are field values.
     * @param  bool  $create If true, the record will be created if it does not exist
     *
     * @throws Error
     */
    public function update(string $id, array $data, bool $create = false): string
    {
        $endpoint = '/data/'.$this->model_name.'/'.$id;
        $body = ['data' => $data, 'create' => $create];
        $result = $this->client->patch($endpoint, $body);

        return $result['result'];
    }

    /**
     * Deletes a record.
     *
     * @param  string  $id Record ID
     * @return bool true if record was deleted
     *
     * @throws Error
     */
    public function delete(string $id): bool
    {
        $endpoint = '/data/'.$this->model_name.'/'.$id;
        $result = $this->client->delete($endpoint);

        return $result['result'];
    }

    /**
     * Retrieves fields and filters metadata.
     *
     * @return array<string, mixed> Array with metadata
     *
     * @throws Error
     */
    public function metadata(): array
    {
        return $this->client->get('/meta/fields/'.$this->model_name);
    }

    /**
     * Get list of model audit logs.
     *
     * @param  string|null  $parent_id parent record ID
     * @param  int  $offset Starting offset
     * @param  int  $limit Maximum number of records to return
     *
     * @throws Error
     */
    public function getAuditLogs(string $parent_id = null, int $offset = 0, int $limit = 0): ListResult
    {
        $endpoint = '/audit/'.$this->model_name;
        if ($parent_id) {
            $endpoint .= '/'.$parent_id;
        }
        $query = ['offset' => $offset];
        if ($limit > 0) {
            $query['limit'] = $limit;
        }
        $result = $this->client->get($endpoint, $query);

        return new ListResult($this->client, $endpoint, $query, $result);
    }

    /**
     * Get list of reports.
     *
     * @param  string|null  $report_id report ID. If specified the method returns a list of archived runs
     * @param  int  $offset Starting offset
     * @param  int  $limit Maximum number of records to return
     * @return ListResult
     *
     * @throws Error
     */
    public function getReports(string $report_id = null, int $offset = 0, int $limit = 0): ListResult
    {
        $endpoint = '/reports/'.$this->model_name;
        if ($report_id) {
            $endpoint .= '/'.$report_id;
        }
        $query = ['offset' => $offset];
        if ($limit > 0) {
            $query['limit'] = $limit;
        }
        $result = $this->client->get($endpoint, $query);

        return new ListResult($this->client, $endpoint, $query, $result);
    }
}
