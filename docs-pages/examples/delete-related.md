\page ex-delete-related Remove Product from Assembly

Use
[Model::deleteRelated()](@ref OneCRM::APIClient::Model::deleteRelated()) method
to remove relationship between two records.

~~~~~~~~~~~~~{.php}
$model = $client->model('Assembly');
$assembly_id = '278ef520-bab3-546f-0e2f-5aab53353bbf';
$product_id = '6d57ea93-65c3-2779-56be-55b9b0525aec';
$result = $model->deleteRelated($assembly_id, 'products', $product_id);
echo json_encode($result, JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
true
~~~~~~~~~~~~~
