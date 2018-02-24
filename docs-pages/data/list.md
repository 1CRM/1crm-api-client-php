\page data-list Retrieving list of records

To fetch a list of records, use the [Model::getList()](@ref OneCRM::APIClient::Model::getList)
method. It returns an instance of [ListResult](@ref OneCRM::APIClient::ListResult) class.

~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$result = $model->getList([], 0, 2);
echo $result->totalResults(), "\n";
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
200
[
    {
        "name": "Kristina Abramowitz",
        "first_name": "Kristina",
        "id": "7eba2a01-6cb6-f38c-d4c2-5a8fc2def9d2",
        "last_name": "Abramowitz",
        "salutation": null,
        "_display": "Kristina Abramowitz"
    },
    {
        "name": "Garret Alejo",
        "first_name": "Garret",
        "id": "346ba8d2-2851-166b-13e6-5a8fc2c18299",
        "last_name": "Alejo",
        "salutation": null,
        "_display": "Garret Alejo"
    }
]
~~~~~~~~~~~~~

Here we specify that we want to start from first record (0 is passed in `$offset` argument),
and we want no more than 2 rescords returned (2 is passed in `$limit` argument). totalResults()
returned 200, telling us that there is more data available. If we want to retrieve next 2 records,
we have to make another request, passing 2 in `$offset`:

~~~~~~~~~~~~~{.php}
$result = $model->getList([], 2, 2);
~~~~~~~~~~~~~


[Model::getist()](@ref OneCRM::APIClient::Model::getList) accepts an array of options that
can be used to refine the request.

### filter_text option

Use the `filter_text` option for generic text search:

~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$result = $model->getList(['filter_text' => 'Michael'], 0, 2);
echo $result->totalResults(), "\n";
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
1
[
    {
        "name": "Michael Whitehead",
        "first_name": "Michael",
        "id": "4ec8fd9d-d035-839e-5356-5a8fc2480082",
        "last_name": "Whitehead",
        "salutation": null,
        "_display": "Michael Whitehead"
    }
]
~~~~~~~~~~~~~

### filters option

Use the `filters` option to filter data:

~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$result = $model->getList(['filters' => ['address_city' => 'San Jose']], 0, 2);
echo $result->totalResults(), "\n";
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
15
[
    {
        "name": "Kristina Abramowitz",
        "first_name": "Kristina",
        "id": "7eba2a01-6cb6-f38c-d4c2-5a8fc2def9d2",
        "last_name": "Abramowitz",
        "salutation": null,
        "_display": "Kristina Abramowitz"
    },
    {
        "name": "Emma Alley",
        "first_name": "Emma",
        "id": "c1edefc7-5595-e61e-0fd9-5a8fc2333dcc",
        "last_name": "Alley",
        "salutation": null,
        "_display": "Emma Alley"
    }
]
~~~~~~~~~~~~~

Another example:

~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$result = $model->getList(['filters' => ['filter_favorites' => true]], 0, 2);
echo $result->totalResults(), "\n";
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
1
[
    {
        "name": "Kristina Abramowitz",
        "first_name": "Kristina",
        "id": "7eba2a01-6cb6-f38c-d4c2-5a8fc2def9d2",
        "last_name": "Abramowitz",
        "salutation": null,
        "_display": "Kristina Abramowitz",
        "favorite": "0"
    }
]
~~~~~~~~~~~~~

### order option

Use the `order` option to return the data in specific order:

~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$result = $model->getList(['order' => 'last_name DESC'], 0, 2);
echo $result->totalResults(), "\n";
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
200
[
    {
        "name": "Arron Ybanez",
        "first_name": "Arron",
        "id": "a8a157b1-a20a-3023-fc7a-5a8fc28d2b4a",
        "last_name": "Ybanez",
        "salutation": null,
        "_display": "Arron Ybanez"
    },
    {
        "name": "Dario Yan",
        "first_name": "Dario",
        "id": "15a7fc37-2711-5b54-af16-5a8fc27fb778",
        "last_name": "Yan",
        "salutation": null,
        "_display": "Dario Yan"
    }
]
~~~~~~~~~~~~~

### fields option

Use the `fields` option to specify a list of fields you want to fetch:

~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$result = $model->getList(['fields' => ['first_name', 'last_name', 'primary_address_city']], 0, 2);
echo $result->totalResults(), "\n";
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
200
[
    {
        "first_name": "Kristina",
        "last_name": "Abramowitz",
        "primary_address_city": "San Jose",
        "id": "7eba2a01-6cb6-f38c-d4c2-5a8fc2def9d2",
        "name": "Kristina Abramowitz",
        "salutation": null,
        "_display": "Kristina Abramowitz"
    },
    {
        "first_name": "Garret",
        "last_name": "Alejo",
        "primary_address_city": "Cupertino",
        "id": "346ba8d2-2851-166b-13e6-5a8fc2c18299",
        "name": "Garret Alejo",
        "salutation": null,
        "_display": "Garret Alejo"
    }
]
~~~~~~~~~~~~~


### query_favorite option

Use the `query_favorite` option if you want a flag returned for each record
telling if the record was added to favorites:

~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$result = $model->getList(['query_favorite' => true], 0, 2);
echo $result->totalResults(), "\n";
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
200
[
    {
        "name": "Kristina Abramowitz",
        "first_name": "Kristina",
        "id": "7eba2a01-6cb6-f38c-d4c2-5a8fc2def9d2",
        "last_name": "Abramowitz",
        "salutation": null,
        "_display": "Kristina Abramowitz",
        "favorite": "0"
    },
    {
        "name": "Garret Alejo",
        "first_name": "Garret",
        "id": "346ba8d2-2851-166b-13e6-5a8fc2c18299",
        "last_name": "Alejo",
        "salutation": null,
        "_display": "Garret Alejo",
        "favorite": null
    }
]
~~~~~~~~~~~~~

\attention
Records added to favorites will have `favorite` field with value of `"0"`
