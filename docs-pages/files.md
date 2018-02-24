\page files Working with files

1CRM uses uploaded files in multiple places. You can upload files as Documents,
attach files to Notes, upload Contacts and Accounts images, etc.

[Files](@ref OneCRM::APIClient::Files) class provides methods to work with 1CRM files.

You can get an instance of Files class by calling [Client::files()](@ref OneCRM::APIClient::Client::files)
method:

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$token = stored_access_token(); // previously obtained access token
$auth = new Authentication\OAuth($token);
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
$files = $client->files();
~~~~~~~~~~~~~

\note
Files are not separate objects in 1CRM. After a file is uploaded, it is stored in a temporary
location for a limited amount of time. To use uploaded file, you use its ID as a value for a field
with `image` or `file_ref` type when calling [Model::create()](@ref OneCRM::APIClient::Model::create)
or [Model::update()](@ref OneCRM::APIClient::Model::update)

\subpage files-upload

\subpage files-use

\subpage files-info

\subpage files-download
