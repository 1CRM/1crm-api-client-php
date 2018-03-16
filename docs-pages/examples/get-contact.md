\page ex-get-contact Retrieve existing contact

This is a basic example of retrieving single record using 1CRM API.

Use [Model::get()](@ref OneCRM::APIClient::Model::get()) method.

It is normally a good idea to specify a list of fields you are interested in,
otherwise all fields will be returned.

~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$contact_id = 'd341cb27-683b-3d9f-9554-5aa798b475f0';
$fields = ['first_name', 'last_name', 'email1', 'primary_account', 'date_entered', 'date_modified', 'assigned_user'];
$contact = $model->get($contact_id, $fields);
echo json_encode($contact, JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
{
    "first_name": "Michael",
    "last_name": "Whitehead",
    "email1": "michael@1crm.com",
    "primary_account": "1CRM Systems Corp.",
    "date_entered": "2018-03-13 09:24:30",
    "date_modified": "2018-03-13 09:24:30",
    "assigned_user": "ademenev",
    "primary_account_id": "32c78a69-3d9c-d5af-29b7-5aa798021f69",
    "id": "d341cb27-683b-3d9f-9554-5aa798b475f0",
    "assigned_user_id": "c6bc0030-460d-3335-e701-5aa798c5ef3e"
}
~~~~~~~~~~~~~
