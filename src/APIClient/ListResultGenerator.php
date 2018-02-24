<?php

namespace OneCRM\APIClient;

/**
 * Generator class for ListResult
 * 
 */
class ListResultGenerator {

    protected $client;
    protected $endpoint;
    protected $query;
    protected $result;

    public function __construct($client, $endpoint, $query, $result) {
        $this->endpoint = $endpoint;
        $this->query = $query;
        $this->result = $result;
        $this->client = $client;
    }

    /**
     * Generator function used to iterate over all results in a foreach loop
     */
    public function generate() {
        $query = $this->query;
        $currentPosition = $query['offset'];
        $result = $this->result;
        while ($currentPosition < $result['total_results']) {
            $rows = $result['records'];
            foreach ($rows as $row) {
                $currentPosition++;
                yield $row;
            }
            if ($currentPosition < $result['total_results']) {
                $query['offset'] = $currentPosition;
                $result = $this->client->get($this->endpoint, $query);
            } else {
                break;
            }
        }
    }
}
