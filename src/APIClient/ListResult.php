<?php

namespace OneCRM\APIClient;

/**
 * Represents result of API call returning a list of records,
 * such as Model::getList() and Model::getRelated()
 */
class ListResult {

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
     * Returns total number of results
     * 
     * Model::getList() and Model::getRelated() return a limited number of records (no more than 200),
     * and a total number of results matching the request. You can use total number of results to decide
     * if you need to send additional requests to fetch more data.
     * 
     */
    public function totalResults() {
        return $this->result['total_results'];
    }

    /**
     * Returns the list of records returned by API call
     */
    public function getRecords() {
        return $this->result['records'];
    }

    /**
     * Returns a generator object used to iterate over all results in a foreach loop.
     * The generator will automatically send additional API requests as needed to fetch more data.
     */
    public function generator() {
        $gen = new ListResultGenerator($this->client, $this->endpoint, $this->query, $this->result);
        return $gen->generate();
    }

}
