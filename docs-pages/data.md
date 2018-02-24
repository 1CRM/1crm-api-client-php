\page Data Working with data

[Model](@ref OneCRM::APIClient::Model) class provides methods to access data stored in 1CRM.

You can get an instance of Model class by calling [Client::model()](@ref OneCRM::APIClient::Client::model)
method, passing model name as parameter:

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$token = stored_access_token(); // previously obtained access token
$auth = new Authentication\OAuth($token);
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
$model = $client->model('Contact');
~~~~~~~~~~~~~

\subpage data-record

\subpage data-list

\subpage data-related

\subpage list-result

\subpage data-create

\subpage data-add-related

\subpage data-update

\subpage data-delete

\subpage meta
