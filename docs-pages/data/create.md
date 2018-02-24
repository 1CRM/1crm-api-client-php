\page data-create Creating records

To create a new record, use the [Model::create()](@ref OneCRM::APIClient::Model::create)
method, passing an array with field values. This method returns the ID of created record.

~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$id = $model->create(['first_name' => 'Andrey', 'last_name' => 'Demenev']);
$result = $model->get($id, ['first_name', 'last_name']);
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "first_name": "Andrey",
    "last_name": "Demenev",
    "id": "5979d952-8714-8239-ae3c-5a9101fabab5"
}
~~~~~~~~~~~~~
