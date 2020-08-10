\page ex-get-audit Get Accounts Audit Logs

This is a basic example of retrieving a list of model Audit logs using 1CRM API.

~~~~~~~~~~~~~{.php}
//Get Accounts audit logs 
$model = $client->model('Account');
$result = $model->getAuditLogs(null, 0, 2); // fetch no more than 2 records, starting from the beginning

printf("There are %d records in total\n", $result->totalResults());
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
There are 1162 records in total
[
    {
        "id": "d1b32ea5-44c3-8fb8-aa14-5ed50426146f",
        "created_by_user": "",
        "created_by": null,
        "date_created": "2020-06-01 13:39:08",
        "parent": "",
        "parent_id": "aabdeac3-5a0c-577b-b32a-5d653164cb4c",
        "field_name": "phone_office",
        "data_type": "phone",
        "before_value_string": null,
        "after_value_string": "+1-999-99-9999",
        "before_value_text": null,
        "after_value_text": null,
        "erased": "0",
        "source": null
    },
    {
        "id": "760202ef-79ec-c9f5-3505-5ec28073a175",
        "created_by_user": "admin",
        "created_by": "1",
        "date_created": "2020-05-18 12:31:03",
        "parent": "",
        "parent_id": "52600b8b-bc77-1980-687b-5ec28069bd95",
        "field_name": "assigned_user_id",
        "data_type": "id",
        "before_value_string": null,
        "after_value_string": "1",
        "before_value_text": null,
        "after_value_text": null,
        "erased": "0",
        "source": null
    }
]
~~~~~~~~~~~~~

~~~~~~~~~~~~~{.php}
//Get a list of audit logs belonging to specified Account record
$account_id = '87056d90-0fbd-1202-f074-5c9b250f15af';
 
$model = $client->model('Account');
$result = $model->getAuditLogs($account_id, 0, 2); // fetch no more than 2 records, starting from the beginning

printf("There are %d records in total\n", $result->totalResults());
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
There are 6 records in total
[
    {
        "id": "877f6492-8efe-2cc3-7c5a-5c9b250724a4",
        "created_by_user": "admin",
        "created_by": "1",
        "date_created": "2019-03-27 07:24:57",
        "parent": "",
        "parent_id": "87056d90-0fbd-1202-f074-5c9b250f15af",
        "field_name": "assigned_user_id",
        "data_type": "id",
        "before_value_string": null,
        "after_value_string": "1",
        "before_value_text": null,
        "after_value_text": null,
        "erased": "0",
        "source": null
    },
    {
        "id": "8780dcdf-373a-d5b1-19d5-5c9b25297b19",
        "created_by_user": "admin",
        "created_by": "1",
        "date_created": "2019-03-27 07:24:57",
        "parent": "",
        "parent_id": "87056d90-0fbd-1202-f074-5c9b250f15af",
        "field_name": "name",
        "data_type": "name",
        "before_value_string": null,
        "after_value_string": "1CRM Systems Corp.",
        "before_value_text": null,
        "after_value_text": null,
        "erased": "0",
        "source": null
    }
]
~~~~~~~~~~~~~
