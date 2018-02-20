<?php

namespace OneCRM\APIClient;

class Calendar {

    private $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function events($start_date, $end_date, array $types = []) {
        $endpoint = '/calendar/events';
        $query = ['start_date' => $start_date, 'end_date' => $end_date];
        if (!empty($types))
            $query['types'] = $types;
        $result = $this->client->get($endpoint, $query);
        return $result['records'];
    }

}
