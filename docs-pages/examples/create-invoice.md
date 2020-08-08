\page ex-create-invoice Create an Invoice with Payment

This is a example of creating an Invoice, a Payment and link this payment with parent Invoice using 1CRM API.

Use [Model::create()](@ref OneCRM::APIClient::Model::create()) method

~~~~~~~~~~~~~{.php}
// prepare data for new record
$contact_id = '8ccb3aaa-3bab-5bbc-4ca4-5c9b2502940f';
$account_id = 'da10a29c-7085-bb94-62ca-5c9b25163842';

$invoice_data = [
	'name' => '1CRM On Premise Annual Subscription for 1 User (Enterprise Edition)',
	'shipping_stage' => 'None',
	'terms' => 'Due on Receipt',
	'description' => 'Annual Subscription',

	'invoice_date' => '2020-01-01',
	'due_date' => '2020-01-01',

	'billing_contact_id' => $contact_id,
	'billing_account_id' => $account_id,

	'amount' => '224.55',
	'amount_due' => '224.55',
];

// obtain model
$model = $client->model('Invoice');
// create record
$invoice_id = $model->create($invoice_data);

//Add Invoice Line Group
$invoice_group_data = [
	'parent_id' => $invoice_id,
	'name' => '',
	'position' => 1,
	'status' => 'Draft',
	'cost' => '138.00',
	'subtotal' => '248.40',
	'total' => '224.55',
	'group_type' => 'products'
];

$model = $client->model('InvoiceLineGroup');
$invoice_group_id = $model->create($invoice_group_data);

//Add Invoice Line (Product)
$product_id = '4c5bb842-9e2e-8cd0-f483-55b9b036661c';
$tax_code_id = 'standard-tax_-code-0000-000000000001';

$invoice_line_data = [
	'invoice_id' => $invoice_id,
	'line_group_id' => $invoice_group_id,
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

$model = $client->model('InvoiceLine');
$invoice_line_id = $model->create($invoice_line_data);

//Add Group Tax
$tax_rate_id = 'e8f046d7-ce41-7a4e-4615-5c9b256c4e1e';

$invoice_tax_data = [
	'invoice_id' => $invoice_id,
	'line_group_id' => $invoice_group_id,
	'name' => 'HST',
	'position' => 1,
	'related_type' => 'TaxRates',
	'related_id' => $tax_rate_id,
	'rate' => 13,
	'type' => 'StandardTax',
	'amount' => '25.83'
];

$model = $client->model('InvoiceAdjustment');
$invoice_tax_id = $model->create($invoice_tax_data);

//Create Payment
$payment_data = [
	'account_id' => $account_id,
	'direction' => 'incoming',
	'payment_date' => '2020-01-01',
	'payment_type' => 'Credit Card',
	'amount' => '224.55',
	'total_amount' => '224.55',

	'related_invoice_id' => $invoice_id,
	'applied_amount' => '224.55'
];

$model = $client->model('Payment');
$payment_id = $model->create($payment_data);

//Link created Payment with parent Invoice
$link_data = [
	'payment_id' => $payment_id,
	'invoice_id' => $invoice_id,
	'amount' => '224.55'
];

$link_model = $client->model('invoices_payments');
$link_model->create($link_data);

//Update Invoice's Amount Due after payment
$model = $client->model('Invoice');
$model->update($invoice_id, ['amount_due' => 0]);

echo "Invoice ID: " . $invoice_id, "\n";
echo "Payment ID: " . $payment_id, "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
Incoice ID: 11520ebd-9496-3fdb-a833-5f2d5dee090c
Payment ID: 25412aa8-34ca-0b40-84c3-5f2d5df40b95
~~~~~~~~~~~~~

To create a record, you first prepare an array with record data. Array keys are
field names, and the values are corresponding data values. Then, obtain an instance
of [Model](@ref OneCRM::APIClient::Model) class, and use 
[create()](@ref OneCRM::APIClient::Model::create()) method to insert the record into
the database and get new record ID.
