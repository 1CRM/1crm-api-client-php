\page data-add-related Adding related records

Most records in 1CRM have other related recors linked to them. For example, Contact
can have a number of related accounts.
To add a related record, use the [Model::addRelated()](@ref OneCRM::APIClient::Model::addRelated)
method.

In the following example, we get a list of accounts related to a Contact, and add all those accounts
to another contact:

~~~~~~~~~~~~~{.php}
$srcContactId = '7eba2a01-6cb6-f38c-d4c2-5a8fc2def9d2';
$dstContactId = '75a60da5-4f35-0574-d768-5a8fc2fca882';
$model = $client->model('Contact');
$result = $model->getRelated($srcContactId, 'accounts');
$account_ids = array_map(function($account) {return $account['id'];}, $result->getRecords());
$result = $model->addRelated($dstContactId, 'accounts', $account_ids);
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
true
~~~~~~~~~~~~~

This is the simplest form of using this method. You just pass an array of related record IDs in
`$data` parameter of [Model::addRelated()](@ref OneCRM::APIClient::Model::addRelated) method.

Some relationships between objects are more complex, they contain not only the ID of related records,
but also additional relationship data. For example, Assembly can contain multiple Products, and for
each product the relationship stores the quantity of the products in this assembly. For such 
relationships, you need to specify additional data:

~~~~~~~~~~~~~{.php}
$productId = 'ee4f2c8a-5eae-5e9c-98ad-55b9b07b4fae';
$assemblyId = 'ad3f7e05-4ab2-6c2a-a4c7-5a910640ed46';
$model = $client->model('Assembly');
$relations = [
    $productId => ['quantity' => 2]
];
$result = $model->addRelated($assemblyId, 'products', $relations);
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
true
~~~~~~~~~~~~~
