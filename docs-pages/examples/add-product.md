\page ex-add-product Add Product to Assembly

Some relationships in 1CRM may have additional attributes. For example,
Contacts to Account relationship does not have additional attributes,
it just records a fact that two records are related. But if we look
at Assembly to Products relationship, we notice that it requires an
additional attribute - quantity of the products in assembly.

When adding relationships using 
[Model::addRelated()](@ref OneCRM::APIClient::Model::addRelated()) method,
you can specify additional attributes as shown below

~~~~~~~~~~~~~{.php}
$model = $client->model('Assembly');
$assembly_id = '278ef520-bab3-546f-0e2f-5aab53353bbf';
// add 2 products with ID 6d57ea93-65c3-2779-56be-55b9b0525aec,
// and 1 product with ID 18661249-c650-e652-b69b-55b9b069b341
$products_data = [
     '6d57ea93-65c3-2779-56be-55b9b0525aec' => ['quantity' => 2],
     '18661249-c650-e652-b69b-55b9b069b341' => ['quantity' => 1]
];
$result = $model->addRelated($assembly_id, 'products', $products_data);
echo json_encode($result, JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
true
~~~~~~~~~~~~~

