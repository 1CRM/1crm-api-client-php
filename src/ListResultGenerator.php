<?php

namespace OneCRM\APIClient;

use Generator;

/**
 * Generator class for ListResult.
 */
class ListResultGenerator
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
     * Generator function used to iterate over all results in a foreach loop.
     *
     * @throws Error
     */
    public function generate(): Generator
    {
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
