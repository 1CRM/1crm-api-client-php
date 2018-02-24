\page data-related Retrieving list of related records

Most records in 1CRM have other related recors linked to them. For example, Contact
can have a number of related accounts.
To fetch a list of related records, use the [Model::getRelated()](@ref OneCRM::APIClient::Model::getRelated)
method. It returns an instance of [ListResult](@ref OneCRM::APIClient::ListResult) class.


~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$result = $model->getRelated('7eba2a01-6cb6-f38c-d4c2-5a8fc2def9d2', 'accounts' [], 0, 2);
echo $result->totalResults(), "\n";
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
2
[
    {
        "balance": "3222.22",
        "balance_payable": "0",
        "is_supplier": "0",
        "credit_limit": null,
        "purchase_credit_limit": null,
        "currency_id": "-99",
        "id": "80ed9241-3612-f3cd-ee4d-5a8fc236c860",
        "credit_limit_usd": null,
        "currency": "US Dollar: $",
        "exchange_rate": "1",
        "purchase_credit_limit_usd": null,
        "name": "360 Vacations",
        "_display": "360 Vacations"
    },
    {
        "balance": "0",
        "balance_payable": "0",
        "is_supplier": "0",
        "credit_limit": null,
        "purchase_credit_limit": null,
        "currency_id": "-99",
        "id": "94b8157d-aff9-023f-3745-5a8fc278192f",
        "credit_limit_usd": null,
        "currency": "US Dollar: $",
        "exchange_rate": "1",
        "purchase_credit_limit_usd": null,
        "name": "ABC FUEL CO",
        "_display": "ABC FUEL CO"
    }
]
~~~~~~~~~~~~~

[Model::getRelated()](@ref OneCRM::APIClient::Model::getRelated) accepts same options as
[Model::getList()](@ref OneCRM::APIClient::Model::getList) - see \ref data-list
