 \page ex-get-leads Retrieve leads list

This is a basic example of retrieving a list of records using 1CRM API.

Use [Model::getList()](@ref OneCRM::APIClient::Model::getList()) method.

It is normally a good idea to specify a list of fields you are interested in,
otherwise only a limited subset of fields will be returned. The order in which
the records are returned depends on the model used. See other examples to learn
how to specify sort order.

Also, you may want to specify offset and limit to retrieve a limited number of
records.

Note that [getList()](@ref OneCRM::APIClient::Model::getList()) returns an instance of
[ListResult](@ref OneCRM::APIClient::ListResult). To get an array with records, use
[getRecords()](@ref OneCRM::APIClient::ListResult::getRecords) methods. To know how many
records there are in total, ignoring the limit, use
[totalResults()](@ref OneCRM::APIClient::ListResult::totalResults) method.

~~~~~~~~~~~~~{.php}
$model = $client->model('Lead');
$fields = ['first_name', 'last_name', 'email1'];
$result = $model->getList(['fields' => $fields], 0, 3); // fetch no more than 3 records, starting from the beginning
printf("There are %d leads in total\n", $result->totalResults());
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
There are 38 leads in total
[
    {
        "first_name": "Laurie",
        "last_name": "Giusti",
        "email1": "mobile52@example.com.au",
        "id": "4158ca78-6f11-ac08-3620-5aa7989bfe31",
        "name": "Laurie Giusti",
        "salutation": null,
        "_display": "Laurie Giusti"
    },
    {
        "first_name": "Maximo",
        "last_name": "Spradlin",
        "email1": "fitness.hr@example.us",
        "id": "43950469-288d-6250-713f-5aa798bd0dd1",
        "name": "Maximo Spradlin",
        "salutation": null,
        "_display": "Maximo Spradlin"
    },
    {
        "first_name": "Marisol",
        "last_name": "Mole",
        "email1": "fitness24@example.info",
        "id": "45cc3a29-11fd-0945-b759-5aa79876fb6d",
        "name": "Marisol Mole",
        "salutation": null,
        "_display": "Marisol Mole"
    }
]
~~~~~~~~~~~~~
