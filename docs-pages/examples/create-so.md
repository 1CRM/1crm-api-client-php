\page ex-create-so Create a Sales Order (with Product Line, Comment, Tax and Taxed Shipping)

This is a example of creating a Sales Order record with Product Line, Comment, Tax and Taxed Shipping using 1CRM API.
****
Use [Model::create()](@ref OneCRM::APIClient::Model::create()) method

~~~~~~~~~~~~~{.php}
// prepare data for new record
$contact_id = '8ccb3aaa-3bab-5bbc-4ca4-5c9b2502940f';
$account_id = 'da10a29c-7085-bb94-62ca-5c9b25163842';

$so_data = [
	'name' => '1CRM On Premise Annual Subscription for 1 User (Enterprise Edition)',
	'so_stage' => 'Ordered',
	'terms' => 'COD',
	'description' => 'Annual Subscription',

	'due_date' => '2020-01-01',

	'billing_contact_id' => $contact_id,
	'billing_account_id' => $account_id,

	'amount' => '291.99',
];

// obtain model
$model = $client->model('SalesOrder');
// create record
$so_id = $model->create($so_data);

//Add Sales Order Line Group
$so_group_data = [
	'parent_id' => $so_id,
	'name' => 'Subscription',
	'position' => 1,
	'status' => 'Draft',
	'cost' => '138.00',
	'subtotal' => '248.40',
	'total' => '291.99',
	'group_type' => 'products'
];

$model = $client->model('SalesOrderLineGroup');
$so_group_id = $model->create($so_group_data);

//Add Sales Order Line (Product)
$product_id = '4c5bb842-9e2e-8cd0-f483-55b9b036661c';
$tax_code_id = 'standard-tax_-code-0000-000000000001';

$so_line_data = [
	'sales_orders_id' => $so_id,
	'line_group_id' => $so_group_id,
	'name' => '1CRM On Premise Annual Subscription for 1 User (Enterprise Edition)',
	'position' => 1,
	'quantity' => 1,
	'related_type' => 'ProductCatalog',
	'related_id' => $product_id,
	'mfr_part_no' => '1CRM-SW-Ent',
	'tax_class_id' => $tax_code_id,
	'cost_price' => '138.00',
	'list_price' => '276.00',
	'unit_price' => '248.40',
	'net_price' => '198.72'
];

$model = $client->model('SalesOrderLine');
$so_line_id = $model->create($so_line_data);

//Add Sales Order Line Comment
$so_comment_data = [
	'sales_orders_id' => $so_id,
	'line_group_id' => $so_group_id,
	'position' => 2,
	'body' => 'Upgrade instance'
];

$model = $client->model('SalesOrderComment');
$so_comment_id = $model->create($so_comment_data);

//Add Taxed Shipping
$tax_class_id = 'standard-tax_-code-0000-000000000001';

$so_shipping_data = [
	'sales_orders_id' => $so_id,
	'line_group_id' => $so_group_id,
	'name' => '',
	'position' => 0,
	'related_type' => 'ShippingProviders',
	'type' => 'TaxedShipping',
	'amount' => '10',
	'tax_class_id' => $tax_class_id
];

$model = $client->model('SalesOrderAdjustment');
$so_shipping_id = $model->create($so_shipping_data);

//Add Group Tax
$tax_rate_id = 'e8f046d7-ce41-7a4e-4615-5c9b256c4e1e';

$so_tax_data = [
	'sales_orders_id' => $so_id,
	'line_group_id' => $so_group_id,
	'name' => 'HST',
	'position' => 1,
	'related_type' => 'TaxRates',
	'related_id' => $tax_rate_id,
	'rate' => 13,
	'type' => 'StandardTax',
	'amount' => '33.59'
];

$model = $client->model('SalesOrderAdjustment');
$so_tax_id = $model->create($so_tax_data);

echo $so_id, "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
f2e3658f-5313-9cc2-d5b8-5f3116e5f7d5
~~~~~~~~~~~~~

To create a record, you first prepare an array with record data. Array keys are
field names, and the values are corresponding data values. Then, obtain an instance
of [Model](@ref OneCRM::APIClient::Model) class, and use 
[create()](@ref OneCRM::APIClient::Model::create()) method to insert the record into
the database and get new record ID.
