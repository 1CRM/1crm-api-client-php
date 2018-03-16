\page ex-delete-note Delete a Note

Use
[Model::delete()](@ref OneCRM::APIClient::Model::delete()) method
to delete a record.

~~~~~~~~~~~~~{.php}
$model = $client->model('Note');
$note_id = '67be6e0c-8760-e213-32fb-5aa79805e790';
$result = $model->delete($note_id);
echo json_encode($result, JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
true
~~~~~~~~~~~~~
