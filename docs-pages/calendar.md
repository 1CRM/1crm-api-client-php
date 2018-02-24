\page calendar Retrieving calendar events

[Calendar](@ref OneCRM::APIClient::Calendar) class provides methods to fetch a list of calendar events.

You can get an instance of Calendar class by calling [Client::calendar()](@ref OneCRM::APIClient::Client::calendar)
method:

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$token = stored_access_token(); // previously obtained access token
$auth = new Authentication\OAuth($token);
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
$calendar = $client->calendar();
~~~~~~~~~~~~~

### Retrieving calendar events

To retrieve a list of calendar events within specified dates range, use 
[Calendar::events()](@ref OneCRM::APIClient::Calendar::events) method, passing
start and end dates. The dates must be strings conforming to `Y-m-d H:i:s` format
as used by PHP date function. Use GMT timezone.

~~~~~~~~~~~~~{.php}
$calendar = $client->calendar();

$result = $calendar->events('2018-03-26 00:00:00', '2018-03-27 23:59:59');
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
[
    {
        "name": "Bad time, will call back",
        "date_start": "2018-03-26 06:45:00",
        "date_due": null,
        "location": null,
        "id": "3d5398a2-f209-a5d2-9cdb-5a8fc2d22297",
        "type": "Call"
    },
    {
        "name": "Follow-up on proposal",
        "date_start": "2018-03-27 08:30:00",
        "date_due": null,
        "location": null,
        "id": "e73a50c1-6687-8a95-364d-5a8fc241ba18",
        "type": "Meeting"
    }
]
~~~~~~~~~~~~~

You can limit returned event types by passing third argument to
[Calendar::events()](@ref OneCRM::APIClient::Calendar::events) method, with an array
of desired event types. Supported types are `Call`, `Meeting`, `Task`, `ProjectTask`

~~~~~~~~~~~~~{.php}
$calendar = $client->calendar();

$result = $calendar->events('2018-03-26 00:00:00', '2018-03-27 23:59:59', ['Call']);
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
[
    {
        "name": "Bad time, will call back",
        "date_start": "2018-03-26 06:45:00",
        "date_due": null,
        "location": null,
        "id": "3d5398a2-f209-a5d2-9cdb-5a8fc2d22297",
        "type": "Call"
    }
]
~~~~~~~~~~~~~
