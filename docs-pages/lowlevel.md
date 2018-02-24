\page Lowlevel Low-level API calls

1CRM API calls are standard HTTP requests, such as GET, POST, PATCH or DELETE.
The API library provides methods for sending arbitrary requests to the API.

You should prefer more high level methods for accessing 1CRM API, as described
in other sections of this documentation, but low-level methods described here
may be useful when talking a customized 1CRM system with custom API endpoints.

\section request Requests with arbitrary HTTP method

You can set an arbitrary request to the API using 
[Client::request](@ref OneCRM::APIClient::Client::request()) method.
You pass HTTP request method, endpoint and an array of options. The options
can be any options accepted by GuzzleHttp\Client.

## Example: sending GET request with query paramaters

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$token = stored_access_token(); // previously obtained access token
$auth = new Authentication\OAuth($token);
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
$result = $client->request('GET', '/data/Contact', ['query' => ['limit' => 2]]);
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "records": [
        {
            "name": "Kristina Abramowitz",
            "first_name": "Kristina",
            "id": "7eba2a01-6cb6-f38c-d4c2-5a8fc2def9d2",
            "last_name": "Abramowitz",
            "salutation": null,
            "_display": "Kristina Abramowitz"
        },
        {
            "name": "Garret Alejo",
            "first_name": "Garret",
            "id": "346ba8d2-2851-166b-13e6-5a8fc2c18299",
            "last_name": "Alejo",
            "salutation": null,
            "_display": "Garret Alejo"
        }
    ],
    "total_results": 200
}
~~~~~~~~~~~~~

In this example, we send a GET request to `/data/Contact` endpoint that returns
a list of Contact records, and add `limit` parameter to return no more than 2
results.

## Example: sending POST request

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$token = stored_access_token(); // previously obtained access token
$auth = new Authentication\OAuth($token);
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
$result = $client->request('POST', '/data/Contact', [
    'json' => ['data' => ['first_name' => 'Andrey', 'last_name' => 'Demenev']]
]);
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "id": "ab05b916-be4c-3b08-1464-5a90e5f5dc5d"
}
~~~~~~~~~~~~~

In this example, we send a POST request to `/data/Contact` endpoint that creates
a new Contact record.

## Example: sending PATCH request

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$token = stored_access_token(); // previously obtained access token
$auth = new Authentication\OAuth($token);
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
$result = $client->request('PATCH', '/data/Contact/ab05b916-be4c-3b08-1464-5a90e5f5dc5d', [
    'json' => ['data' => ['email1' => 'andrey@1crm.com']]
]);
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "result": true
}
~~~~~~~~~~~~~

In this example, we send a POST request to `/data/Contact/:id` endpoint that updates
a Contact record.

## Example: sending DELETE request

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$token = stored_access_token(); // previously obtained access token
$auth = new Authentication\OAuth($token);
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
$result = $client->request('DELETE', '/data/Contact/ab05b916-be4c-3b08-1464-5a90e5f5dc5d');
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "result": true
}
~~~~~~~~~~~~~

In this example, we send a DELETE request to `/data/Contact/:id` endpoint that deletes
a Contact record.

\section get GET

[Client::get](@ref OneCRM::APIClient::Client::get()) is a shortcut method for sending a GET
request.

The above example for GET request can be rewritten as follows:

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$token = stored_access_token(); // previously obtained access token
$auth = new Authentication\OAuth($token);
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
$result = $client->get('/data/Contact', ['limit' => 2]);
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "records": [
        {
            "name": "Kristina Abramowitz",
            "first_name": "Kristina",
            "id": "7eba2a01-6cb6-f38c-d4c2-5a8fc2def9d2",
            "last_name": "Abramowitz",
            "salutation": null,
            "_display": "Kristina Abramowitz"
        },
        {
            "name": "Garret Alejo",
            "first_name": "Garret",
            "id": "346ba8d2-2851-166b-13e6-5a8fc2c18299",
            "last_name": "Alejo",
            "salutation": null,
            "_display": "Garret Alejo"
        }
    ],
    "total_results": 200
}
~~~~~~~~~~~~~

\section post POST

[Client::post](@ref OneCRM::APIClient::Client::post()) is a shortcut method for sending a POST
request.

The above example for POST request can be rewritten as follows:

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$token = stored_access_token(); // previously obtained access token
$auth = new Authentication\OAuth($token);
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
$result = $client->post('/data/Contact', ['data' => ['first_name' => 'Andrey', 'last_name' => 'Demenev']]);
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "id": "ab05b916-be4c-3b08-1464-5a90e5f5dc5d"
}
~~~~~~~~~~~~~

\section patch PATCH

[Client::patch](@ref OneCRM::APIClient::Client::patch()) is a shortcut method for sending a PATCH
request.

The above example for PATCH request can be rewritten as follows:

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$token = stored_access_token(); // previously obtained access token
$auth = new Authentication\OAuth($token);
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
$result = $client->patch('/data/Contact/ab05b916-be4c-3b08-1464-5a90e5f5dc5d', [
    'data' => ['email1' => 'andrey@1crm.com']
]);
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "result": true
}
~~~~~~~~~~~~~

\section delete DELETE

[Client::delete](@ref OneCRM::APIClient::Client::delete()) is a shortcut method for sending a DELETE
request.

The above example for DELETE request can be rewritten as follows:

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$token = stored_access_token(); // previously obtained access token
$auth = new Authentication\OAuth($token);
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
$result = $client->delete('/data/Contact/ab05b916-be4c-3b08-1464-5a90e5f5dc5d');
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "result": true
}
~~~~~~~~~~~~~

