<?php

namespace OneCRM\APIClient;

use Generator;

/**
 * Represents result of API call returning a list of records,
 * such as Model::getList() and Model::getRelated()
 */
class ListResult
{
    /**
     * @param  array<string, mixed>  $query
     * @param  array<string, mixed>  $result
     */
    public function __construct(protected Client $client, protected string $endpoint, protected array $query, protected array $result)
    {
        //
    }

    /**
     * Returns total number of results.
     *
     * Model::getList() and Model::getRelated() return a limited number of records (no more than 200),
     * and a total number of results matching the request. You can use total number of results to decide
     * if you need to send additional requests to fetch more data.
     */
    public function totalResults(): int
    {
        return $this->result['total_results'];
    }

    /**
     * Returns the list of records returned by API call.
     *
     * @return array<string, mixed>
     */
    public function getRecords(): array
    {
        return $this->result['records'];
    }

    /**
     * Returns a generator object used to iterate over all results in a foreach loop.
     * The generator will automatically send additional API requests as needed to fetch more data.
     */
    public function generator(): Generator
    {
        $gen = new ListResultGenerator($this->client, $this->endpoint, $this->query, $this->result);

        return $gen->generate();
    }
}
