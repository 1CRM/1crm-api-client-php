<?php

namespace OneCRM\APIClient;

/**
 * Used to obtain information about caalendar events.
 */
class Calendar {

    protected $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * Returns a list of events within specified dates range.
     * 
     * @param $start_date Dates range start. The value must conform to `Y-m-d H:i:s` format as used by PHP date function. Use GMT timezone
     * @param $end_date Dates range end. The value must conform to `Y-m-d H:i:s` format as used by PHP date function. Use GMT timezone
     */
    public function events($start_date, $end_date, array $types = []) {
        $endpoint = '/calendar/events';
        $query = ['start_date' => $start_date, 'end_date' => $end_date];
        if (!empty($types))
            $query['types'] = $types;
        $result = $this->client->get($endpoint, $query);
        return $result['records'];
    }

}
