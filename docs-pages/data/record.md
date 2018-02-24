\page data-record Retrieving single record

To fetch a single record by ID, use the [Model::get](@ref OneCRM::APIClient::Model::get)
method.

~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$result = $model->get('7eba2a01-6cb6-f38c-d4c2-5a8fc2def9d2');
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "id": "7eba2a01-6cb6-f38c-d4c2-5a8fc2def9d2",
    "deleted": "0",
    "date_entered": "2018-02-23 07:28:28",
    "date_modified": "2018-02-23 07:28:28",
    // ...... omited long list of fields
    "photo_filename": null,
    "photo_thumb": null,
    "chat_activity": "0",
    "mautic_id": null,
    "livechat_activity": "0"
}
~~~~~~~~~~~~~

You can specify a list of fields you want returned:

~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$result = $model->get(
    '7eba2a01-6cb6-f38c-d4c2-5a8fc2def9d2', 
    ['first_name', 'last_name', 'email1']
);
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "first_name": "Kristina",
    "last_name": "Abramowitz",
    "email1": "code.mobile.code@example.co.uk",
    "id": "7eba2a01-6cb6-f38c-d4c2-5a8fc2def9d2"
}
~~~~~~~~~~~~~
