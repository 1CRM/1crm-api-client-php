<?php

namespace OneCRM\APIClient;

class ListResult {

    private $client;
    private $endpoint;
    private $query;
    private $result;

    public function __construct($client, $endpoint, $query, $result) {
        $this->endpoint = $endpoint;
        $this->query = $query;
        $this->result = $result;
        $this->client = $client;
    }

    public function totalResults() {
        return $this->result['total_results'];
    }

    public function getRecords() {
        return $this->result['records'];
    }

    public function generator() {
        $gen = new ListResultGenerator($this->client, $this->endpoint, $this->query, $this->result);
        return $gen->generate();
    }

}
