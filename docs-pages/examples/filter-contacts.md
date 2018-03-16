\page ex-filter-contacts Filter contacts list

When using [Model::getList()](@ref OneCRM::APIClient::Model::getList()) method,
you may want to retrieve records matching a specific criteria. Use 'filters' option
for this purpose.

~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$fields = ['first_name', 'last_name'];
$filters = ['first_name' => 'John'];
$result = $model->getList(['fields' => $fields, 'filters' => $filters ], 0, 3); // fetch no more than 3 records, starting from the beginning
printf("There are %d contacts in total\n", $result->totalResults());
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
There are 3 contacts in total
[
    {
        "first_name": "Johnathan",
        "last_name": "Burgher",
        "id": "53e82904-1b6d-3771-654e-5aa798c22995",
        "name": "Johnathan Burgher",
        "salutation": null,
        "_display": "Johnathan Burgher"
    },
    {
        "first_name": "John",
        "last_name": "Eastham",
        "id": "9d501f39-1b86-7c7d-42aa-5aa79802c8b9",
        "name": "John Eastham",
        "salutation": null,
        "_display": "John Eastham"
    },
    {
        "first_name": "John",
        "last_name": "Smith",
        "id": "a7be92d7-9870-b338-bf04-5348d0b8836f",
        "name": "John Smith",
        "salutation": null,
        "_display": "John Smith"
    }
]
~~~~~~~~~~~~~

\note
You cannot use arbitrary fields for filtering. To get a list of available filters, use
[Model::metadata()](@ref OneCRM::APIClient::Model::metadata) method. In 1CRM Enterprise
edition, you can use Module Designer to enable filtering by arbitrary fields.