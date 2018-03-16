\page ex-create-account Create an account

This is a basic example of creating a record using 1CRM API.

Use [Model::create()](@ref OneCRM::APIClient::Model::create()) method

~~~~~~~~~~~~~{.php}
// prepare data for new record
$account_data = [
    'name' => '1CRM Systems Corp.',
    'email1' => 'info@1crm.com',
    'is_supplier' => true,
    'industry' => 'Technology',
    'account_type' => 'Supplier',
    'phone_office' => '+1 999-888-7777',
    'billing_address_city' => 'Victoria',
    'billing_address_state' => 'BC',
    'billing_address_country' => 'Canada',
    'billing_address_street' => '688 Falkland Road',
    'billing_address_postalcode' => 'V8S 4L5',
    'website' => 'https://www.1crm.com/'
];
// obtain model
$model = $client->model('Account');
// create record
$account_id = $model->create($account_data);
echo $account_id, "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
47c17392-2bc8-6cf7-acf1-5aab34e92204
~~~~~~~~~~~~~

To create a record, you first prepare an array with record data. Array keys are
field names, and the values are corresponding data values. Then, obtain an instance
of [Model](@ref OneCRM::APIClient::Model) class, and use 
[create()](@ref OneCRM::APIClient::Model::create()) method to insert the record into
the database and get new record ID.
