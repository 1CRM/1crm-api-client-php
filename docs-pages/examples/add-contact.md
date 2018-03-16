\page ex-add-contact Add Contact to Account

To add a related record to another record, use 
[Model::addRelated()](@ref OneCRM::APIClient::Model::addRelated()) method.

~~~~~~~~~~~~~{.php}
$model = $client->model('Account');
$account_id = '5576a702-f97b-104d-cbf4-5aa798008296';
$contact_id = 'd341cb27-683b-3d9f-9554-5aa798b475f0';
$result = $model->addRelated($account_id, 'contacts', $contact_id);
echo json_encode($result, JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
true
~~~~~~~~~~~~~

You can add multiple records in one API call

~~~~~~~~~~~~~{.php}
$model = $client->model('Account');
$account_id = '5576a702-f97b-104d-cbf4-5aa798008296';
$contact_ids = ['d341cb27-683b-3d9f-9554-5aa798b475f0', '749e95fb-21b4-7cab-b8cd-5aa7987b6f55'];
$result = $model->addRelated($account_id, 'contacts', $contact_ids);
echo json_encode($result, JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
true
~~~~~~~~~~~~~

