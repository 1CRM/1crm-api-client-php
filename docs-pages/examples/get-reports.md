\page ex-get-reports Get Accounts Reports and Archived Runs 

This is a basic example of retrieving a list of model Reports and Report Archived Runs using 1CRM API.

~~~~~~~~~~~~~{.php}
//Get Accounts reports 
$model = $client->model('Account');
$result = $model->getReports(null, 0, 1); // fetch no more than 1 record, starting from the beginning

printf("There are %d records in total\n", $result->totalResults());
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
There are 3 records in total
[
    {
        "id": "dc601c78-9ca6-b062-81b8-5c9b258d766c",
        "date_entered": "2019-03-27 07:24:18",
        "date_modified": "2019-03-27 07:24:18",
        "modified_user": "admin",
        "modified_user_id": "1",
        "assigned_user": "admin",
        "assigned_user_id": "1",
        "shared_with": null,
        "created_by_user": "admin",
        "created_by": "1",
        "deleted": "0",
        "name": "Account Activity Report",
        "description": "",
        "primary_module": "Accounts",
        "sources_spec": "a:1:{i:0;a:5:{s:4:\"name\";s:4:\"acco\";s:7:\"display\";s:7:\"primary\";s:6:\"module\";s:8:\"Accounts\";s:9:\"bean_name\";s:7:\"Account\";s:8:\"required\";i:1;}}",
        "columns_spec": "a:5:{i:0;a:4:{s:5:\"field\";s:4:\"name\";s:5:\"vname\";s:8:\"LBL_NAME\";s:12:\"vname_module\";s:8:\"Accounts\";s:6:\"source\";s:4:\"acco\";}i:1;a:4:{s:5:\"field\";s:12:\"phone_office\";s:5:\"vname\";s:16:\"LBL_PHONE_OFFICE\";s:12:\"vname_module\";s:8:\"Accounts\";s:6:\"source\";s:4:\"acco\";}i:2;a:4:{s:5:\"field\";s:6:\"email1\";s:5:\"vname\";s:9:\"LBL_EMAIL\";s:12:\"vname_module\";s:8:\"Accounts\";s:6:\"source\";s:4:\"acco\";}i:3;a:4:{s:5:\"field\";s:18:\"last_activity_date\";s:5:\"vname\";s:17:\"LBL_LAST_ACTIVITY\";s:12:\"vname_module\";s:8:\"Accounts\";s:6:\"source\";s:4:\"acco\";}i:4;a:4:{s:5:\"field\";s:13:\"assigned_user\";s:5:\"vname\";s:15:\"LBL_ASSIGNED_TO\";s:12:\"vname_module\";s:8:\"Accounts\";s:6:\"source\";s:4:\"acco\";}}",
        "filters_spec": "a:0:{}",
        "filter_values": "",
        "sort_order": "a:1:{i:0;a:1:{s:5:\"field\";s:18:\"last_activity_date\";}}",
        "run_method": "interactive",
        "next_run": null,
        "run_interval": "1",
        "run_interval_unit": "days",
        "chart_name": "",
        "chart_type": "",
        "chart_options": null,
        "chart_title": "",
        "chart_rollover": "",
        "chart_description": "",
        "chart_series": "",
        "from_template": "LBL_STD_REPORT_ACCOUNT_ACTIVITY",
        "from_template_id": "c50ec48e-5b0a-ffb6-b2ce-5c9b25d2a72e",
        "last_run": null,
        "export_ids": "0",
        "max_keep": null
    }
]
~~~~~~~~~~~~~

~~~~~~~~~~~~~{.php}
//Get a list of Account's report archived runs
$report_id = 'dc601c78-9ca6-b062-81b8-5c9b258d766c';
$model = $client->model('Account');
$result = $model->getReports($report_id, 0, 1); // fetch no more than 1 record, starting from the beginning

printf("There are %d records in total\n", $result->totalResults());
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

Output:
~~~~~~~~~~~~~
There are 10 records in total
[
    {
        "id": "706b0a81-67cb-625a-eacd-5f3150bf2f7e",
        "date_entered": "2020-08-10 13:51:24",
        "date_modified": "2020-08-10 13:51:24",
        "modified_user": "admin",
        "modified_user_id": "1",
        "assigned_user": "admin",
        "assigned_user_id": "1",
        "created_by_user": "admin",
        "created_by": "1",
        "deleted": "0",
        "reportdata_number": "39",
        "full_name": "39",
        "report": "Account Activity Report",
        "report_id": "dc601c78-9ca6-b062-81b8-5c9b258d766c",
        "cache_filename": "report.tsv",
        "groups": "a:0:{}",
        "sources_spec": "a:1:{s:4:\"acco\";a:6:{s:4:\"name\";s:4:\"acco\";s:7:\"display\";s:7:\"primary\";s:6:\"module\";s:8:\"Accounts\";s:9:\"bean_name\";s:7:\"Account\";s:8:\"required\";i:1;s:9:\"link_name\";N;}}",
        "columns_spec": "a:17:{i:0;a:16:{s:5:\"field\";s:4:\"name\";s:5:\"vname\";s:8:\"LBL_NAME\";s:12:\"vname_module\";s:8:\"Accounts\";s:6:\"source\";N;s:5:\"alias\";s:4:\"name\";s:4:\"type\";s:4:\"name\";s:6:\"dbType\";s:7:\"varchar\";s:11:\"detail_link\";b:1;s:5:\"width\";i:50;s:7:\"comment\";s:19:\"Name of the account\";s:14:\"unified_search\";b:1;s:7:\"audited\";b:1;s:10:\"vname_list\";s:21:\"LBL_LIST_ACCOUNT_NAME\";s:8:\"required\";b:1;s:7:\"default\";s:0:\"\";s:3:\"len\";i:150;}i:1;a:13:{s:5:\"field\";s:12:\"phone_office\";s:5:\"vname\";s:16:\"LBL_PHONE_OFFICE\";s:12:\"vname_module\";s:8:\"Accounts\";s:6:\"source\";N;s:5:\"alias\";s:12:\"phone_office\";s:4:\"type\";s:5:\"phone\";s:6:\"dbType\";s:7:\"varchar\";s:5:\"width\";i:23;s:10:\"vname_list\";s:16:\"LBL_PHONE_OFFICE\";s:7:\"audited\";b:1;s:14:\"unified_search\";b:1;s:7:\"comment\";s:23:\"The office phone number\";s:3:\"len\";i:40;}i:2;a:11:{s:5:\"field\";s:6:\"email1\";s:5:\"vname\";s:9:\"LBL_EMAIL\";s:12:\"vname_module\";s:8:\"Accounts\";s:6:\"source\";N;s:5:\"alias\";s:6:\"email1\";s:4:\"type\";s:5:\"email\";s:6:\"dbType\";s:7:\"varchar\";s:5:\"width\";i:23;s:7:\"audited\";b:1;s:7:\"comment\";s:21:\"Primary email address\";s:3:\"len\";i:150;}i:3;a:8:{s:5:\"field\";s:18:\"last_activity_date\";s:5:\"vname\";s:17:\"LBL_LAST_ACTIVITY\";s:12:\"vname_module\";s:8:\"Accounts\";s:6:\"source\";N;s:5:\"alias\";s:18:\"last_activity_date\";s:4:\"type\";s:8:\"datetime\";s:5:\"width\";i:30;s:8:\"editable\";b:0;}i:4;a:23:{s:5:\"field\";s:13:\"assigned_user\";s:5:\"vname\";s:15:\"LBL_ASSIGNED_TO\";s:12:\"vname_module\";s:8:\"Accounts\";s:6:\"source\";N;s:5:\"alias\";s:13:\"assigned_user\";s:4:\"type\";s:3:\"ref\";s:10:\"reportable\";b:1;s:11:\"detail_link\";b:1;s:9:\"bean_name\";s:4:\"User\";s:7:\"id_name\";s:16:\"assigned_user_id\";s:9:\"show_icon\";b:1;s:4:\"icon\";s:4:\"User\";s:5:\"width\";i:30;s:10:\"vname_list\";s:22:\"LBL_LIST_ASSIGNED_USER\";s:7:\"audited\";b:1;s:7:\"comment\";s:26:\"User ID assigned to record\";s:15:\"duplicate_merge\";b:0;s:10:\"massupdate\";b:1;s:8:\"required\";b:1;s:15:\"module_designer\";s:10:\"label_only\";s:14:\"from_app_field\";s:17:\"app.assigned_user\";s:10:\"module_dir\";s:5:\"Users\";s:13:\"model_id_name\";s:16:\"assigned_user_id\";}i:5;a:10:{s:5:\"field\";s:7:\"balance\";s:6:\"hidden\";b:1;s:5:\"vname\";s:22:\"LBL_BALANCE_RECEIVABLE\";s:10:\"vname_list\";s:16:\"LBL_LIST_BALANCE\";s:4:\"type\";s:13:\"base_currency\";s:19:\"display_currency_id\";s:11:\"currency_id\";s:8:\"editable\";b:0;s:6:\"dbType\";s:6:\"double\";s:3:\"len\";i:16;s:12:\"vname_module\";s:8:\"Accounts\";}i:6;a:10:{s:5:\"field\";s:15:\"balance_payable\";s:6:\"hidden\";b:1;s:5:\"vname\";s:19:\"LBL_BALANCE_PAYABLE\";s:10:\"vname_list\";s:24:\"LBL_LIST_BALANCE_PAYABLE\";s:4:\"type\";s:13:\"base_currency\";s:19:\"display_currency_id\";s:11:\"currency_id\";s:8:\"editable\";b:0;s:6:\"dbType\";s:6:\"double\";s:3:\"len\";i:16;s:12:\"vname_module\";s:8:\"Accounts\";}i:7;a:8:{s:5:\"field\";s:11:\"is_supplier\";s:6:\"hidden\";b:1;s:5:\"vname\";s:15:\"LBL_IS_SUPPLIER\";s:4:\"type\";s:4:\"bool\";s:7:\"default\";i:0;s:10:\"updateable\";b:0;s:10:\"massupdate\";b:1;s:12:\"vname_module\";s:8:\"Accounts\";}i:8;a:13:{s:5:\"field\";s:12:\"credit_limit\";s:6:\"hidden\";b:1;s:5:\"vname\";s:22:\"LBL_SALES_CREDIT_LIMIT\";s:10:\"vname_list\";s:21:\"LBL_LIST_CREDIT_LIMIT\";s:4:\"type\";s:8:\"currency\";s:7:\"audited\";b:1;s:6:\"dbType\";s:6:\"double\";s:3:\"len\";i:16;s:10:\"base_field\";s:16:\"credit_limit_usd\";s:8:\"currency\";s:8:\"currency\";s:11:\"currency_id\";s:11:\"currency_id\";s:13:\"exchange_rate\";s:13:\"exchange_rate\";s:12:\"vname_module\";s:8:\"Accounts\";}i:9;a:13:{s:5:\"field\";s:21:\"purchase_credit_limit\";s:6:\"hidden\";b:1;s:5:\"vname\";s:25:\"LBL_PURCHASE_CREDIT_LIMIT\";s:10:\"vname_list\";s:30:\"LBL_LIST_PURCHASE_CREDIT_LIMIT\";s:4:\"type\";s:8:\"currency\";s:7:\"audited\";b:1;s:6:\"dbType\";s:6:\"double\";s:3:\"len\";i:16;s:10:\"base_field\";s:25:\"purchase_credit_limit_usd\";s:8:\"currency\";s:8:\"currency\";s:11:\"currency_id\";s:11:\"currency_id\";s:13:\"exchange_rate\";s:13:\"exchange_rate\";s:12:\"vname_module\";s:8:\"Accounts\";}i:10;a:13:{s:5:\"field\";s:11:\"currency_id\";s:6:\"hidden\";b:1;s:4:\"type\";s:2:\"id\";s:10:\"reportable\";b:0;s:8:\"inferred\";b:1;s:7:\"for_ref\";s:8:\"currency\";s:7:\"default\";s:3:\"-99\";s:5:\"vname\";s:6:\"LBL_ID\";s:6:\"dbType\";s:4:\"char\";s:7:\"charset\";s:5:\"ascii\";s:3:\"len\";i:36;s:8:\"editable\";b:0;s:12:\"vname_module\";s:8:\"Accounts\";}i:11;a:14:{s:5:\"field\";s:2:\"id\";s:6:\"hidden\";b:1;s:5:\"vname\";s:6:\"LBL_ID\";s:12:\"vname_module\";s:3:\"app\";s:8:\"required\";b:1;s:10:\"reportable\";b:0;s:4:\"type\";s:2:\"id\";s:7:\"comment\";s:17:\"Unique identifier\";s:8:\"editable\";b:0;s:15:\"module_designer\";s:8:\"disabled\";s:14:\"from_app_field\";s:6:\"app.id\";s:6:\"dbType\";s:4:\"char\";s:7:\"charset\";s:5:\"ascii\";s:3:\"len\";i:36;}i:12;a:13:{s:5:\"field\";s:16:\"credit_limit_usd\";s:6:\"hidden\";b:1;s:4:\"type\";s:13:\"base_currency\";s:8:\"inferred\";b:1;s:12:\"for_currency\";s:12:\"credit_limit\";s:7:\"audited\";b:1;s:5:\"vname\";s:22:\"LBL_SALES_CREDIT_LIMIT\";s:6:\"dbType\";s:6:\"double\";s:3:\"len\";i:16;s:8:\"currency\";s:8:\"currency\";s:11:\"currency_id\";s:11:\"currency_id\";s:13:\"exchange_rate\";s:13:\"exchange_rate\";s:12:\"vname_module\";s:8:\"Accounts\";}i:13;a:12:{s:5:\"field\";s:8:\"currency\";s:6:\"hidden\";b:1;s:4:\"type\";s:3:\"ref\";s:14:\"from_app_field\";s:12:\"app.currency\";s:9:\"bean_name\";s:8:\"Currency\";s:5:\"vname\";s:12:\"LBL_CURRENCY\";s:10:\"massupdate\";b:0;s:13:\"exchange_rate\";s:13:\"exchange_rate\";s:11:\"detail_link\";b:1;s:7:\"id_name\";s:11:\"currency_id\";s:12:\"vname_module\";s:8:\"Accounts\";s:10:\"module_dir\";s:10:\"Currencies\";}i:14;a:10:{s:5:\"field\";s:13:\"exchange_rate\";s:6:\"hidden\";b:1;s:5:\"vname\";s:17:\"LBL_EXCHANGE_RATE\";s:4:\"type\";s:6:\"double\";s:8:\"required\";b:0;s:14:\"decimal_places\";i:5;s:7:\"default\";i:1;s:8:\"inferred\";b:1;s:12:\"for_currency\";s:8:\"currency\";s:12:\"vname_module\";s:8:\"Accounts\";}i:15;a:13:{s:5:\"field\";s:25:\"purchase_credit_limit_usd\";s:6:\"hidden\";b:1;s:4:\"type\";s:13:\"base_currency\";s:8:\"inferred\";b:1;s:12:\"for_currency\";s:21:\"purchase_credit_limit\";s:7:\"audited\";b:1;s:5:\"vname\";s:25:\"LBL_PURCHASE_CREDIT_LIMIT\";s:6:\"dbType\";s:6:\"double\";s:3:\"len\";i:16;s:8:\"currency\";s:8:\"currency\";s:11:\"currency_id\";s:11:\"currency_id\";s:13:\"exchange_rate\";s:13:\"exchange_rate\";s:12:\"vname_module\";s:8:\"Accounts\";}i:16;a:14:{s:5:\"field\";s:16:\"assigned_user_id\";s:6:\"hidden\";b:1;s:4:\"type\";s:2:\"id\";s:10:\"reportable\";b:0;s:8:\"inferred\";b:1;s:7:\"for_ref\";s:13:\"assigned_user\";s:8:\"required\";b:1;s:7:\"audited\";b:1;s:5:\"vname\";s:6:\"LBL_ID\";s:6:\"dbType\";s:4:\"char\";s:7:\"charset\";s:5:\"ascii\";s:3:\"len\";i:36;s:8:\"editable\";b:0;s:12:\"vname_module\";s:8:\"Accounts\";}}",
        "filters_spec": null,
        "filter_values": null,
        "sort_order": "a:1:{i:0;a:1:{s:5:\"field\";s:18:\"last_activity_date\";}}",
        "archived": "0",
        "name": null,
        "description": null,
        "chart_type": "",
        "chart_options": "",
        "chart_title": "",
        "chart_rollover": "",
        "chart_description": "",
        "chart_series": "",
        "record_count": "184",
        "record_offsets": null,
        "primary_module": "Accounts",
        "export_ids": "0"
    }
]
~~~~~~~~~~~~~
