\page data-update Updating records

To update a record, use the [Model::update()](@ref OneCRM::APIClient::Model::update)
method, passing an array with field values.

~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$result = $model->update('5979d952-8714-8239-ae3c-5a9101fabab5', ['email1' => 'andrey@1crm.com']);
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
true
~~~~~~~~~~~~~
