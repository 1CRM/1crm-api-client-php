\page data-delete Deleting records

To delete a record, use the [Model::delete()](@ref OneCRM::APIClient::Model::delete)
method.

~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$result = $model->delete('5979d952-8714-8239-ae3c-5a9101fabab5');
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
true
~~~~~~~~~~~~~
