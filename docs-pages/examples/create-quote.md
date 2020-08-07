\page ex-create-quote Create a Quote

This is a example of creating a Quote record with Product Line, Comment, Discount and Tax using 1CRM API.

Use [Model::create()](@ref OneCRM::APIClient::Model::create()) method

~~~~~~~~~~~~~{.php}
// prepare data for new record
$contact_id = '8ccb3aaa-3bab-5bbc-4ca4-5c9b2502940f';
$account_id = 'da10a29c-7085-bb94-62ca-5c9b25163842';

$quote_data = [
	'name' => '1CRM On Premise Annual Subscription for 1 User (Enterprise Edition)',
	'quote_stage' => 'Draft',
	'terms' => 'Due on Receipt',
	'description' => 'Annual Subscription',

	'valid_until' => '2020-01-01',

	'billing_contact_id' => $contact_id,
	'billing_account_id' => $account_id,

	'amount' => '224.55',
];

// obtain model
$model = $client->model('Quote');
// create record
$quote_id = $model->create($quote_data);

//Add Quote Line Group
$quote_group_data = [
	'parent_id' => $quote_id,
	'name' => 'Subscription',
	'position' => 1,
	'status' => 'Draft',
	'cost' => '138.00',
	'subtotal' => '248.40',
	'total' => '224.55',
	'group_type' => 'products'
];

$model = $client->model('QuoteLineGroup');
$quote_group_id = $model->create($quote_group_data);

//Add Quote Line (Product)
$product_id = '4c5bb842-9e2e-8cd0-f483-55b9b036661c';
$tax_code_id = 'standard-tax_-code-0000-000000000001';

$quote_line_data = [
	'quote_id' => $quote_id,
	'line_group_id' => $quote_group_id,
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

$model = $client->model('QuoteLine');
$quote_line_id = $model->create($quote_line_data);

//Add Quote Line Comment
$quote_comment_data = [
	'quote_id' => $quote_id,
	'line_group_id' => $quote_group_id,
	'position' => 2,
	'body' => 'Upgrade instance'
];

$model = $client->model('QuoteComment');
$quote_comment_id = $model->create($quote_comment_data);

//Add Group Discount
$discount_id = 'ec2b0187-2e99-5217-76fc-5c9b256ecddd';

$quote_discount_data = [
	'quote_id' => $quote_id,
	'line_group_id' => $quote_group_id,
	'name' => 'Preferred Customer',
	'position' => 0,
	'related_type' => 'Discounts',
	'related_id' => $discount_id,
	'rate' => 20,
	'type' => 'StandardDiscount',
	'amount' => '49.68'
];

$model = $client->model('QuoteAdjustment');
$quote_discount_id = $model->create($quote_discount_data);

//Add Group Tax
$tax_rate_id = 'e8f046d7-ce41-7a4e-4615-5c9b256c4e1e';

$quote_tax_data = [
	'quote_id' => $quote_id,
	'line_group_id' => $quote_group_id,
	'name' => 'HST',
	'position' => 1,
	'related_type' => 'TaxRates',
	'related_id' => $tax_rate_id,
	'rate' => 13,
	'type' => 'StandardTax',
	'amount' => '25.83'
];

$model = $client->model('QuoteAdjustment');
$quote_tax_id = $model->create($quote_tax_data);

echo $quote_id, "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
3b8a8183-466e-8dec-ec50-5f2d428edaf7
~~~~~~~~~~~~~

To create a record, you first prepare an array with record data. Array keys are
field names, and the values are corresponding data values. Then, obtain an instance
of [Model](@ref OneCRM::APIClient::Model) class, and use 
[create()](@ref OneCRM::APIClient::Model::create()) method to insert the record into
the database and get new record ID.
