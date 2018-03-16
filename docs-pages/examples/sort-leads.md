\page ex-sort-leads Retrieve leads in specific order

When using [Model::getList()](@ref OneCRM::APIClient::Model::getList()) method,
you may want to retrieve the records in specific order. Use 'order' option
for this purpose.

\section ex-sort-asc Soring in ascending order

~~~~~~~~~~~~~{.php}
$model = $client->model('Lead');
$fields = ['first_name', 'last_name'];
$result = $model->getList(['fields' => $fields, 'order' => 'last_name'], 0, 3); // fetch no more than 3 records, starting from the beginning
printf("There are %d leads in total\n", $result->totalResults());
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
There are 38 leads in total
[
    {
        "first_name": "Alton",
        "last_name": "Arriaga",
        "id": "4da808b9-c6df-2407-9b0f-5aa798878d1d",
        "name": "Alton Arriaga",
        "salutation": null,
        "_display": "Alton Arriaga"
    },
    {
        "first_name": "Wilda",
        "last_name": "Bakke",
        "id": "438b96a9-2603-2854-681f-5aa798cdf157",
        "name": "Wilda Bakke",
        "salutation": null,
        "_display": "Wilda Bakke"
    },
    {
        "first_name": "Craig",
        "last_name": "Bleau",
        "id": "4b561e06-c3b2-c1f3-0dc3-5aa798663683",
        "name": "Craig Bleau",
        "salutation": null,
        "_display": "Craig Bleau"
    }
]
~~~~~~~~~~~~~

\section ex-sort-desc Soring in descending order

~~~~~~~~~~~~~{.php}
$model = $client->model('Lead');
$fields = ['first_name', 'last_name'];
$result = $model->getList(['fields' => $fields, 'order' => 'last_name desc'], 0, 3); // fetch no more than 3 records, starting from the beginning
printf("There are %d leads in total\n", $result->totalResults());
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
[
    {
        "first_name": "Angelo",
        "last_name": "Winston",
        "id": "dc3c817d-49e1-a0d5-ecbf-5aa798bf8354",
        "name": "Angelo Winston",
        "salutation": null,
        "_display": "Angelo Winston"
    },
    {
        "first_name": "Michael",
        "last_name": "Whitehead",
        "id": "d341cb27-683b-3d9f-9554-5aa798b475f0",
        "name": "Michael Whitehead",
        "salutation": null,
        "_display": "Michael Whitehead"
    },
    {
        "first_name": "Maximo",
        "last_name": "Spradlin",
        "id": "43950469-288d-6250-713f-5aa798bd0dd1",
        "name": "Maximo Spradlin",
        "salutation": null,
        "_display": "Maximo Spradlin"
    }
]
~~~~~~~~~~~~~

