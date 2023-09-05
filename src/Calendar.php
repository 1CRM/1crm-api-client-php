<?php

namespace OneCRM\APIClient;

/**
 * Used to obtain information about calendar events.
 */
class Calendar
{
    public function __construct(protected Client $client)
    {
        //
    }

    /**
     * Returns a list of events within specified dates range.
     *
     * @param  string  $start_date Dates range start. The value must conform to `Y-m-d H:i:s` format as used by PHP date function. Use GMT timezone
     * @param  string  $end_date Dates range end. The value must conform to `Y-m-d H:i:s` format as used by PHP date function. Use GMT timezone
     * @param  array<string, mixed>  $types
     * @return array<string, mixed>
     *
     * @throws Error
     */
    public function events(string $start_date, string $end_date, array $types = []): array
    {
        $endpoint = '/calendar/events';
        $query = ['start_date' => $start_date, 'end_date' => $end_date];
        if (! empty($types)) {
            $query['types'] = $types;
        }
        $result = $this->client->get($endpoint, $query);

        return $result['records'];
    }
}
