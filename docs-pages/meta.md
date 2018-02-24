\page meta Obtaining model metadata

Using the [Model::metadata()](@ref OneCRM::APIClient::Model::metadata)
method, you can obtain model metadata, containing information about model
fields and filters

~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$result = $model->metadata();
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "fields": {
        "id": {
            "vname": "ID",
            "vname_module": "app",
            "required": true,
            "reportable": false,
            "type": "id",
            "comment": "Unique identifier",
            "editable": false,
            "module_designer": "disabled",
            "from_app_field": "app.id",
            "name": "id",
            "dbType": "char",
            "charset": "ascii",
            "len": 36,
            "source": {
                "type": "db"
            }
        },
        "deleted": {
            "vname": "Deleted",
            "vname_module": "app",
            "type": "bool",
            "required": true,
            "default": 0,
            "editable": false,
            "reportable": false,
            "module_designer": "disabled",
            "from_app_field": "app.deleted",
            "name": "deleted",
            "source": {
                "type": "db"
            }
        },
        "date_entered": {
            "vname": "Date Created",
            "vname_module": "app",
            "type": "datetime",
            "required": true,
            "editable": false,
            "module_designer": "label_only",
            "from_app_field": "app.date_entered",
            "name": "date_entered",
            "source": {
                "type": "db"
            }
        },
        "date_modified": {
            "vname": "Last Modified",
            "vname_module": "app",
            "type": "datetime",
            "required": true,
            "editable": false,
            "module_designer": "label_only",
            "from_app_field": "app.date_modified",
            "name": "date_modified",
            "source": {
                "type": "db"
            }
        },
        "modified_user": {
            "id_name": "modified_user_id",
            "vname": "Modified by",
            "vname_module": "app",
            "type": "ref",
            "bean_name": "User",
            "isnull": false,
            "reportable": true,
            "required": true,
            "comment": "User who last modified record",
            "editable": false,
            "module_designer": "label_only",
            "from_app_field": "app.modified_user",
            "name": "modified_user",
            "detail_link": true,
            "source": {
                "type": "non-db"
            }
        },
        "modified_user_id": {
            "name": "modified_user_id",
            "type": "id",
            "reportable": false,
            "inferred": true,
            "for_ref": "modified_user",
            "required": true,
            "vname": "ID",
            "isnull": false,
            "dbType": "char",
            "charset": "ascii",
            "len": 36,
            "editable": false,
            "source": {
                "type": "db"
            }
        },
        "assigned_user": {
            "id_name": "assigned_user_id",
            "vname": "Assigned to",
            "vname_list": "User",
            "vname_module": "app",
            "type": "ref",
            "bean_name": "User",
            "reportable": true,
            "audited": true,
            "comment": "User ID assigned to record",
            "duplicate_merge": false,
            "massupdate": true,
            "required": true,
            "module_designer": "label_only",
            "from_app_field": "app.assigned_user",
            "name": "assigned_user",
            "detail_link": true,
            "source": {
                "type": "non-db"
            }
        },
        "assigned_user_id": {
            "name": "assigned_user_id",
            "type": "id",
            "reportable": false,
            "inferred": true,
            "for_ref": "assigned_user",
            "required": true,
            "audited": true,
            "vname": "ID",
            "dbType": "char",
            "charset": "ascii",
            "len": 36,
            "editable": false,
            "source": {
                "type": "db"
            }
        },
        "created_by_user": {
            "id_name": "created_by",
            "vname": "Created by",
            "vname_module": "app",
            "type": "ref",
            "bean_name": "User",
            "isnull": false,
            "comment": "User ID who created the record",
            "editable": false,
            "module_designer": "label_only",
            "from_app_field": "app.created_by_user",
            "name": "created_by_user",
            "detail_link": true,
            "source": {
                "type": "non-db"
            }
        },
        "created_by": {
            "name": "created_by",
            "type": "id",
            "reportable": false,
            "inferred": true,
            "for_ref": "created_by_user",
            "vname": "ID",
            "isnull": false,
            "dbType": "char",
            "charset": "ascii",
            "len": 36,
            "editable": false,
            "source": {
                "type": "db"
            }
        },
        "name": {
            "vname": "Name",
            "type": "name",
            "source": {
                "type": "person_name",
                "fields": [
                    "first_name",
                    "last_name",
                    "salutation"
                ]
            },
            "importable": false,
            "unified_search": true,
            "name": "name",
            "dbType": "varchar",
            "len": 150,
            "detail_link": true
        },
        "primary_account": {
            "vname": "Primary Account",
            "vname_list": "Account Name",
            "type": "ref",
            "bean_name": "Account",
            "importable": false,
            "massupdate": false,
            "audited": true,
            "name": "primary_account",
            "detail_link": true,
            "source": {
                "type": "non-db"
            },
            "id_name": "primary_account_id"
        },
        "primary_account_id": {
            "name": "primary_account_id",
            "type": "id",
            "reportable": false,
            "inferred": true,
            "for_ref": "primary_account",
            "audited": true,
            "vname": "ID",
            "dbType": "char",
            "charset": "ascii",
            "len": 36,
            "editable": false,
            "source": {
                "type": "db"
            }
        },
        "b2c_account": {
            "vname": "B2C Account",
            "type": "ref",
            "bean_name": "Account",
            "id_name": "primary_contact_for",
            "importable": false,
            "massupdate": false,
            "reportable": false,
            "name": "b2c_account",
            "detail_link": true,
            "source": {
                "type": "non-db"
            }
        },
        "primary_contact_for": {
            "name": "primary_contact_for",
            "type": "id",
            "reportable": false,
            "inferred": true,
            "for_ref": "b2c_account",
            "vname": "ID",
            "dbType": "char",
            "charset": "ascii",
            "len": 36,
            "editable": false,
            "source": {
                "type": "db"
            }
        },
        "categories": {
            "vname": "Category",
            "vname_list": "Category",
            "type": "multienum",
            "options": [
                {
                    "label": "Business",
                    "value": "Business"
                },
                {
                    "label": "Company Staff",
                    "value": "Company Staff"
                },
                {
                    "label": "Customers",
                    "value": "Customers"
                },
                {
                    "label": "Friends & Family",
                    "value": "Friends and Family"
                },
                {
                    "label": "Partners",
                    "value": "Partners"
                },
                {
                    "label": "Personal Services",
                    "value": "Personal Services"
                },
                {
                    "label": "Press & Analysts",
                    "value": "Press and Analysts"
                },
                {
                    "label": "Professional Advisors",
                    "value": "Professional Advisors"
                },
                {
                    "label": "Restaurants",
                    "value": "Restaurants"
                },
                {
                    "label": "Suppliers",
                    "value": "Suppliers"
                }
            ],
            "len": 40,
            "multi_select_group": "category",
            "multi_select_count": 10,
            "massupdate": true,
            "name": "categories",
            "dbType": "varchar",
            "charset": "ascii",
            "source": {
                "type": "multienum"
            }
        },
        "category": {
            "name": "category",
            "type": "enum",
            "options": [
                {
                    "label": "Business",
                    "value": "Business"
                },
                {
                    "label": "Company Staff",
                    "value": "Company Staff"
                },
                {
                    "label": "Customers",
                    "value": "Customers"
                },
                {
                    "label": "Friends & Family",
                    "value": "Friends and Family"
                },
                {
                    "label": "Partners",
                    "value": "Partners"
                },
                {
                    "label": "Personal Services",
                    "value": "Personal Services"
                },
                {
                    "label": "Press & Analysts",
                    "value": "Press and Analysts"
                },
                {
                    "label": "Professional Advisors",
                    "value": "Professional Advisors"
                },
                {
                    "label": "Restaurants",
                    "value": "Restaurants"
                },
                {
                    "label": "Suppliers",
                    "value": "Suppliers"
                }
            ],
            "reportable": false,
            "massupdate": false,
            "multi_select_group": "category",
            "vname": "Category",
            "len": 50,
            "dbType": "varchar",
            "charset": "ascii",
            "source": {
                "type": "db"
            }
        },
        "category2": {
            "name": "category2",
            "type": "enum",
            "options": [
                {
                    "label": "Business",
                    "value": "Business"
                },
                {
                    "label": "Company Staff",
                    "value": "Company Staff"
                },
                {
                    "label": "Customers",
                    "value": "Customers"
                },
                {
                    "label": "Friends & Family",
                    "value": "Friends and Family"
                },
                {
                    "label": "Partners",
                    "value": "Partners"
                },
                {
                    "label": "Personal Services",
                    "value": "Personal Services"
                },
                {
                    "label": "Press & Analysts",
                    "value": "Press and Analysts"
                },
                {
                    "label": "Professional Advisors",
                    "value": "Professional Advisors"
                },
                {
                    "label": "Restaurants",
                    "value": "Restaurants"
                },
                {
                    "label": "Suppliers",
                    "value": "Suppliers"
                }
            ],
            "reportable": false,
            "massupdate": false,
            "multi_select_group": "category",
            "vname": "Category",
            "len": 50,
            "dbType": "varchar",
            "charset": "ascii",
            "source": {
                "type": "db"
            }
        },
        "category3": {
            "name": "category3",
            "type": "enum",
            "options": [
                {
                    "label": "Business",
                    "value": "Business"
                },
                {
                    "label": "Company Staff",
                    "value": "Company Staff"
                },
                {
                    "label": "Customers",
                    "value": "Customers"
                },
                {
                    "label": "Friends & Family",
                    "value": "Friends and Family"
                },
                {
                    "label": "Partners",
                    "value": "Partners"
                },
                {
                    "label": "Personal Services",
                    "value": "Personal Services"
                },
                {
                    "label": "Press & Analysts",
                    "value": "Press and Analysts"
                },
                {
                    "label": "Professional Advisors",
                    "value": "Professional Advisors"
                },
                {
                    "label": "Restaurants",
                    "value": "Restaurants"
                },
                {
                    "label": "Suppliers",
                    "value": "Suppliers"
                }
            ],
            "reportable": false,
            "massupdate": false,
            "multi_select_group": "category",
            "vname": "Category",
            "len": 50,
            "dbType": "varchar",
            "charset": "ascii",
            "source": {
                "type": "db"
            }
        },
        "category4": {
            "name": "category4",
            "type": "enum",
            "options": [
                {
                    "label": "Business",
                    "value": "Business"
                },
                {
                    "label": "Company Staff",
                    "value": "Company Staff"
                },
                {
                    "label": "Customers",
                    "value": "Customers"
                },
                {
                    "label": "Friends & Family",
                    "value": "Friends and Family"
                },
                {
                    "label": "Partners",
                    "value": "Partners"
                },
                {
                    "label": "Personal Services",
                    "value": "Personal Services"
                },
                {
                    "label": "Press & Analysts",
                    "value": "Press and Analysts"
                },
                {
                    "label": "Professional Advisors",
                    "value": "Professional Advisors"
                },
                {
                    "label": "Restaurants",
                    "value": "Restaurants"
                },
                {
                    "label": "Suppliers",
                    "value": "Suppliers"
                }
            ],
            "reportable": false,
            "massupdate": false,
            "multi_select_group": "category",
            "vname": "Category",
            "len": 50,
            "dbType": "varchar",
            "charset": "ascii",
            "source": {
                "type": "db"
            }
        },
        "category5": {
            "name": "category5",
            "type": "enum",
            "options": [
                {
                    "label": "Business",
                    "value": "Business"
                },
                {
                    "label": "Company Staff",
                    "value": "Company Staff"
                },
                {
                    "label": "Customers",
                    "value": "Customers"
                },
                {
                    "label": "Friends & Family",
                    "value": "Friends and Family"
                },
                {
                    "label": "Partners",
                    "value": "Partners"
                },
                {
                    "label": "Personal Services",
                    "value": "Personal Services"
                },
                {
                    "label": "Press & Analysts",
                    "value": "Press and Analysts"
                },
                {
                    "label": "Professional Advisors",
                    "value": "Professional Advisors"
                },
                {
                    "label": "Restaurants",
                    "value": "Restaurants"
                },
                {
                    "label": "Suppliers",
                    "value": "Suppliers"
                }
            ],
            "reportable": false,
            "massupdate": false,
            "multi_select_group": "category",
            "vname": "Category",
            "len": 50,
            "dbType": "varchar",
            "charset": "ascii",
            "source": {
                "type": "db"
            }
        },
        "category6": {
            "name": "category6",
            "type": "enum",
            "options": [
                {
                    "label": "Business",
                    "value": "Business"
                },
                {
                    "label": "Company Staff",
                    "value": "Company Staff"
                },
                {
                    "label": "Customers",
                    "value": "Customers"
                },
                {
                    "label": "Friends & Family",
                    "value": "Friends and Family"
                },
                {
                    "label": "Partners",
                    "value": "Partners"
                },
                {
                    "label": "Personal Services",
                    "value": "Personal Services"
                },
                {
                    "label": "Press & Analysts",
                    "value": "Press and Analysts"
                },
                {
                    "label": "Professional Advisors",
                    "value": "Professional Advisors"
                },
                {
                    "label": "Restaurants",
                    "value": "Restaurants"
                },
                {
                    "label": "Suppliers",
                    "value": "Suppliers"
                }
            ],
            "reportable": false,
            "massupdate": false,
            "multi_select_group": "category",
            "vname": "Category",
            "len": 50,
            "dbType": "varchar",
            "charset": "ascii",
            "source": {
                "type": "db"
            }
        },
        "category7": {
            "name": "category7",
            "type": "enum",
            "options": [
                {
                    "label": "Business",
                    "value": "Business"
                },
                {
                    "label": "Company Staff",
                    "value": "Company Staff"
                },
                {
                    "label": "Customers",
                    "value": "Customers"
                },
                {
                    "label": "Friends & Family",
                    "value": "Friends and Family"
                },
                {
                    "label": "Partners",
                    "value": "Partners"
                },
                {
                    "label": "Personal Services",
                    "value": "Personal Services"
                },
                {
                    "label": "Press & Analysts",
                    "value": "Press and Analysts"
                },
                {
                    "label": "Professional Advisors",
                    "value": "Professional Advisors"
                },
                {
                    "label": "Restaurants",
                    "value": "Restaurants"
                },
                {
                    "label": "Suppliers",
                    "value": "Suppliers"
                }
            ],
            "reportable": false,
            "massupdate": false,
            "multi_select_group": "category",
            "vname": "Category",
            "len": 50,
            "dbType": "varchar",
            "charset": "ascii",
            "source": {
                "type": "db"
            }
        },
        "category8": {
            "name": "category8",
            "type": "enum",
            "options": [
                {
                    "label": "Business",
                    "value": "Business"
                },
                {
                    "label": "Company Staff",
                    "value": "Company Staff"
                },
                {
                    "label": "Customers",
                    "value": "Customers"
                },
                {
                    "label": "Friends & Family",
                    "value": "Friends and Family"
                },
                {
                    "label": "Partners",
                    "value": "Partners"
                },
                {
                    "label": "Personal Services",
                    "value": "Personal Services"
                },
                {
                    "label": "Press & Analysts",
                    "value": "Press and Analysts"
                },
                {
                    "label": "Professional Advisors",
                    "value": "Professional Advisors"
                },
                {
                    "label": "Restaurants",
                    "value": "Restaurants"
                },
                {
                    "label": "Suppliers",
                    "value": "Suppliers"
                }
            ],
            "reportable": false,
            "massupdate": false,
            "multi_select_group": "category",
            "vname": "Category",
            "len": 50,
            "dbType": "varchar",
            "charset": "ascii",
            "source": {
                "type": "db"
            }
        },
        "category9": {
            "name": "category9",
            "type": "enum",
            "options": [
                {
                    "label": "Business",
                    "value": "Business"
                },
                {
                    "label": "Company Staff",
                    "value": "Company Staff"
                },
                {
                    "label": "Customers",
                    "value": "Customers"
                },
                {
                    "label": "Friends & Family",
                    "value": "Friends and Family"
                },
                {
                    "label": "Partners",
                    "value": "Partners"
                },
                {
                    "label": "Personal Services",
                    "value": "Personal Services"
                },
                {
                    "label": "Press & Analysts",
                    "value": "Press and Analysts"
                },
                {
                    "label": "Professional Advisors",
                    "value": "Professional Advisors"
                },
                {
                    "label": "Restaurants",
                    "value": "Restaurants"
                },
                {
                    "label": "Suppliers",
                    "value": "Suppliers"
                }
            ],
            "reportable": false,
            "massupdate": false,
            "multi_select_group": "category",
            "vname": "Category",
            "len": 50,
            "dbType": "varchar",
            "charset": "ascii",
            "source": {
                "type": "db"
            }
        },
        "category10": {
            "name": "category10",
            "type": "enum",
            "options": [
                {
                    "label": "Business",
                    "value": "Business"
                },
                {
                    "label": "Company Staff",
                    "value": "Company Staff"
                },
                {
                    "label": "Customers",
                    "value": "Customers"
                },
                {
                    "label": "Friends & Family",
                    "value": "Friends and Family"
                },
                {
                    "label": "Partners",
                    "value": "Partners"
                },
                {
                    "label": "Personal Services",
                    "value": "Personal Services"
                },
                {
                    "label": "Press & Analysts",
                    "value": "Press and Analysts"
                },
                {
                    "label": "Professional Advisors",
                    "value": "Professional Advisors"
                },
                {
                    "label": "Restaurants",
                    "value": "Restaurants"
                },
                {
                    "label": "Suppliers",
                    "value": "Suppliers"
                }
            ],
            "reportable": false,
            "massupdate": false,
            "multi_select_group": "category",
            "vname": "Category",
            "len": 50,
            "dbType": "varchar",
            "charset": "ascii",
            "source": {
                "type": "db"
            }
        },
        "business_role": {
            "vname": "Business Role",
            "type": "enum",
            "options": [
                {
                    "label": "CEO",
                    "value": "CEO"
                },
                {
                    "label": "MIS",
                    "value": "MIS"
                },
                {
                    "label": "CFO",
                    "value": "CFO"
                },
                {
                    "label": "Sales",
                    "value": "Sales"
                },
                {
                    "label": "Admin",
                    "value": "Admin"
                }
            ],
            "len": 40,
            "massupdate": true,
            "audited": true,
            "name": "business_role",
            "dbType": "varchar",
            "charset": "ascii",
            "source": {
                "type": "db"
            }
        },
        "last_activity_date": {
            "vname": "Last Activity Date",
            "type": "datetime",
            "editable": false,
            "name": "last_activity_date",
            "source": {
                "type": "db"
            }
        },
        "salutation": {
            "vname": "Salutation",
            "type": "enum",
            "options": [
                {
                    "label": "Mr.",
                    "value": "Mr."
                },
                {
                    "label": "Ms.",
                    "value": "Ms."
                },
                {
                    "label": "Mrs.",
                    "value": "Mrs."
                },
                {
                    "label": "Dr.",
                    "value": "Dr."
                },
                {
                    "label": "Prof.",
                    "value": "Prof."
                }
            ],
            "massupdate": false,
            "len": 20,
            "comment": "Contact salutation (e.g., Mr, Ms)",
            "name": "salutation",
            "dbType": "varchar",
            "charset": "ascii",
            "source": {
                "type": "db"
            }
        },
        "first_name": {
            "vname": "First Name",
            "type": "varchar",
            "len": 100,
            "comment": "First name of the contact",
            "name": "first_name",
            "source": {
                "type": "db"
            }
        },
        "last_name": {
            "vname": "Last Name",
            "type": "name",
            "len": 100,
            "comment": "Last name of the contact",
            "required": true,
            "name": "last_name",
            "dbType": "varchar",
            "detail_link": true,
            "source": {
                "type": "db"
            }
        },
        "lead_source": {
            "vname": "Lead Source",
            "type": "enum",
            "options": [
                {
                    "label": "Cold Call",
                    "value": "Cold Call"
                },
                {
                    "label": "Existing Customer",
                    "value": "Existing Customer"
                },
                {
                    "label": "Self Generated",
                    "value": "Self Generated"
                },
                {
                    "label": "Employee",
                    "value": "Employee"
                },
                {
                    "label": "Partner",
                    "value": "Partner"
                },
                {
                    "label": "Public Relations",
                    "value": "Public Relations"
                },
                {
                    "label": "Direct Mail",
                    "value": "Direct Mail"
                },
                {
                    "label": "Conference",
                    "value": "Conference"
                },
                {
                    "label": "Trade Show",
                    "value": "Trade Show"
                },
                {
                    "label": "Web Site",
                    "value": "Web Site"
                },
                {
                    "label": "Customer Portal",
                    "value": "Customer Portal"
                },
                {
                    "label": "Word of mouth",
                    "value": "Word of mouth"
                },
                {
                    "label": "Email",
                    "value": "Email"
                },
                {
                    "label": "Other",
                    "value": "Other"
                }
            ],
            "len": 100,
            "comment": "How did the contact come about",
            "massupdate": true,
            "name": "lead_source",
            "dbType": "varchar",
            "charset": "ascii",
            "source": {
                "type": "db"
            }
        },
        "title": {
            "vname": "Title",
            "type": "varchar",
            "len": 50,
            "comment": "The title of the contact",
            "vname_list": "Title",
            "audited": true,
            "list_subtitle": true,
            "name": "title",
            "source": {
                "type": "db"
            }
        },
        "department": {
            "vname": "Department",
            "type": "varchar",
            "len": 100,
            "comment": "The department of the contact",
            "audited": true,
            "name": "department",
            "source": {
                "type": "db"
            }
        },
        "reports_to": {
            "vname": "Reports To",
            "type": "ref",
            "comment": "The contact this contact reports to",
            "bean_name": "Contact",
            "massupdate": true,
            "name": "reports_to",
            "detail_link": true,
            "source": {
                "type": "non-db"
            },
            "id_name": "reports_to_id"
        },
        "reports_to_id": {
            "name": "reports_to_id",
            "type": "id",
            "reportable": false,
            "inferred": true,
            "for_ref": "reports_to",
            "vname": "ID",
            "dbType": "char",
            "charset": "ascii",
            "len": 36,
            "editable": false,
            "source": {
                "type": "db"
            }
        },
        "birthdate": {
            "vname": "Birthdate",
            "massupdate": false,
            "type": "date",
            "comment": "The birthdate of the contact",
            "name": "birthdate",
            "source": {
                "type": "db"
            }
        },
        "do_not_call": {
            "vname": "Do Not Call",
            "type": "bool",
            "dbType": "varchar",
            "len": 3,
            "default": 0,
            "audited": true,
            "comment": "An indicator of whether contact can be called",
            "massupdate": true,
            "name": "do_not_call",
            "source": {
                "type": "db"
            }
        },
        "email_accounts": {
            "vname": "Accounting Contact",
            "type": "bool",
            "dbType": "varchar",
            "len": 3,
            "default": 0,
            "audited": true,
            "comment": "An indicator of whether we should email the account invoice\nto this client",
            "massupdate": true,
            "name": "email_accounts",
            "source": {
                "type": "db"
            }
        },
        "phone_home": {
            "vname": "Home Phone",
            "type": "phone",
            "unified_search": true,
            "comment": "Home phone number of the contact",
            "name": "phone_home",
            "len": 40,
            "width": 18,
            "dbType": "varchar",
            "source": {
                "type": "db"
            }
        },
        "phone_home__raw": {
            "name": "phone_home__raw",
            "type": "varchar",
            "reportable": false,
            "editable": false,
            "inferred": true,
            "len": 40,
            "source": {
                "type": "db"
            }
        },
        "phone_mobile": {
            "vname": "Mobile Phone",
            "type": "phone",
            "unified_search": true,
            "comment": "Mobile phone number of the contact",
            "name": "phone_mobile",
            "len": 40,
            "width": 18,
            "dbType": "varchar",
            "source": {
                "type": "db"
            }
        },
        "phone_mobile__raw": {
            "name": "phone_mobile__raw",
            "type": "varchar",
            "reportable": false,
            "editable": false,
            "inferred": true,
            "len": 40,
            "source": {
                "type": "db"
            }
        },
        "phone_work": {
            "vname": "Office Phone",
            "type": "phone",
            "audited": true,
            "unified_search": true,
            "comment": "Work phone number of the contact",
            "name": "phone_work",
            "len": 40,
            "width": 18,
            "dbType": "varchar",
            "source": {
                "type": "db"
            }
        },
        "phone_work__raw": {
            "name": "phone_work__raw",
            "type": "varchar",
            "reportable": false,
            "editable": false,
            "inferred": true,
            "len": 40,
            "source": {
                "type": "db"
            }
        },
        "phone_other": {
            "vname": "Other Phone",
            "type": "phone",
            "unified_search": true,
            "comment": "Other phone number for the contact",
            "name": "phone_other",
            "len": 40,
            "width": 18,
            "dbType": "varchar",
            "source": {
                "type": "db"
            }
        },
        "phone_other__raw": {
            "name": "phone_other__raw",
            "type": "varchar",
            "reportable": false,
            "editable": false,
            "inferred": true,
            "len": 40,
            "source": {
                "type": "db"
            }
        },
        "phone_fax": {
            "vname": "Fax Number",
            "type": "fax",
            "unified_search": true,
            "comment": "Contact fax number",
            "name": "phone_fax",
            "len": 40,
            "width": 18,
            "dbType": "varchar",
            "source": {
                "type": "db"
            }
        },
        "phone_fax__raw": {
            "name": "phone_fax__raw",
            "type": "varchar",
            "reportable": false,
            "editable": false,
            "inferred": true,
            "len": 40,
            "source": {
                "type": "db"
            }
        },
        "skype_id": {
            "vname": "Skype ID",
            "type": "skype",
            "unified_search": true,
            "comment": "Contact Skype ID",
            "name": "skype_id",
            "width": 18,
            "source": {
                "type": "db"
            }
        },
        "email1": {
            "vname": "Email",
            "type": "email",
            "audited": true,
            "unified_search": true,
            "comment": "Primary email address of the contact",
            "vname_list": "Email",
            "name": "email1",
            "len": 150,
            "dbType": "varchar",
            "width": 18,
            "source": {
                "type": "db"
            }
        },
        "email2": {
            "vname": "Other Email",
            "type": "email",
            "unified_search": true,
            "comment": "Secondary email address of the contact",
            "vname_list": "Email",
            "name": "email2",
            "len": 150,
            "dbType": "varchar",
            "width": 18,
            "source": {
                "type": "db"
            }
        },
        "assistant": {
            "vname": "Assistant",
            "type": "varchar",
            "len": 75,
            "unified_search": true,
            "comment": "Name of the assistant of the contact",
            "name": "assistant",
            "source": {
                "type": "db"
            }
        },
        "assistant_phone": {
            "vname": "Assistant Phone",
            "type": "phone",
            "unified_search": true,
            "comment": "Phone number of the assistant of the contact",
            "name": "assistant_phone",
            "len": 40,
            "width": 18,
            "dbType": "varchar",
            "source": {
                "type": "db"
            }
        },
        "assistant_phone__raw": {
            "name": "assistant_phone__raw",
            "type": "varchar",
            "reportable": false,
            "editable": false,
            "inferred": true,
            "len": 40,
            "source": {
                "type": "db"
            }
        },
        "email_opt_out": {
            "vname": "Email Opt Out",
            "type": "bool",
            "dbType": "varchar",
            "len": 3,
            "default": 0,
            "comment": "Indicator whether the contact has elected to opt out of\nemails",
            "massupdate": true,
            "name": "email_opt_out",
            "source": {
                "type": "db"
            }
        },
        "email_opt_in": {
            "vname": "Email Opt In",
            "type": "bool",
            "default": 0,
            "massupdate": false,
            "name": "email_opt_in",
            "source": {
                "type": "db"
            }
        },
        "email_opt_in_date": {
            "type": "date",
            "editable": false,
            "vname": "Email Opt-In Date",
            "name": "email_opt_in_date",
            "source": {
                "type": "db"
            }
        },
        "website": {
            "vname": "Website",
            "type": "url",
            "name": "website",
            "len": 255,
            "dbType": "varchar",
            "width": 18,
            "source": {
                "type": "db"
            }
        },
        "primary_address_street": {
            "vname": "Primary Address Street",
            "type": "varchar",
            "len": 150,
            "comment": "Street address for primary address",
            "name": "primary_address_street",
            "source": {
                "type": "db"
            }
        },
        "primary_address_city": {
            "vname": "Primary Address City",
            "vname_list": "City",
            "type": "varchar",
            "len": 100,
            "comment": "City for primary address",
            "name": "primary_address_city",
            "source": {
                "type": "db"
            }
        },
        "primary_address_state": {
            "vname": "Primary Address State",
            "vname_list": "State",
            "type": "varchar",
            "len": 100,
            "comment": "State for primary address",
            "name": "primary_address_state",
            "source": {
                "type": "db"
            }
        },
        "primary_address_postalcode": {
            "vname": "Primary Address Postal Code",
            "type": "varchar",
            "len": 20,
            "comment": "Postal code for primary address",
            "name": "primary_address_postalcode",
            "source": {
                "type": "db"
            }
        },
        "primary_address_country": {
            "vname": "Primary Address Country",
            "type": "varchar",
            "len": 100,
            "comment": "Country for primary address",
            "name": "primary_address_country",
            "source": {
                "type": "db"
            }
        },
        "primary_address_statecode": {
            "vname": "Primary Address State Code",
            "type": "varchar",
            "len": 100,
            "name": "primary_address_statecode",
            "source": {
                "type": "db"
            }
        },
        "primary_address_countrycode": {
            "vname": "Primary Address Country Code",
            "type": "varchar",
            "len": 100,
            "name": "primary_address_countrycode",
            "source": {
                "type": "db"
            }
        },
        "alt_address_street": {
            "vname": "Alternate Address Street",
            "type": "varchar",
            "len": 150,
            "comment": "Street address for alternate address",
            "name": "alt_address_street",
            "source": {
                "type": "db"
            }
        },
        "alt_address_city": {
            "vname": "Alternate Address City",
            "type": "varchar",
            "len": 100,
            "comment": "City for alternate address",
            "name": "alt_address_city",
            "source": {
                "type": "db"
            }
        },
        "alt_address_state": {
            "vname": "Alternate Address State",
            "type": "varchar",
            "len": 100,
            "comment": "State for alternate address",
            "name": "alt_address_state",
            "source": {
                "type": "db"
            }
        },
        "alt_address_postalcode": {
            "vname": "Alternate Address Postal Code",
            "type": "varchar",
            "len": 20,
            "comment": "Postal code for alternate address",
            "name": "alt_address_postalcode",
            "source": {
                "type": "db"
            }
        },
        "alt_address_country": {
            "vname": "Alternate Address Country",
            "type": "varchar",
            "len": 100,
            "comment": "Country for alternate address",
            "name": "alt_address_country",
            "source": {
                "type": "db"
            }
        },
        "alt_address_statecode": {
            "vname": "Alternate Address State Code",
            "type": "varchar",
            "len": 100,
            "name": "alt_address_statecode",
            "source": {
                "type": "db"
            }
        },
        "alt_address_countrycode": {
            "vname": "Alternate Address Country Code",
            "type": "varchar",
            "len": 100,
            "name": "alt_address_countrycode",
            "source": {
                "type": "db"
            }
        },
        "description": {
            "vname": "Description",
            "type": "text",
            "comment": "Description of contact",
            "name": "description",
            "multiline": true,
            "source": {
                "type": "db"
            }
        },
        "portal_name": {
            "vname": "Portal Name",
            "type": "varchar",
            "len": 255,
            "comment": "Name as it appears in the portal",
            "name": "portal_name",
            "source": {
                "type": "db"
            }
        },
        "portal_active": {
            "vname": "Portal Active",
            "type": "bool",
            "required": true,
            "default": 0,
            "comment": "Indicator whether this contact is a portal user",
            "massupdate": true,
            "name": "portal_active",
            "source": {
                "type": "db"
            }
        },
        "portal_app": {
            "vname": "Portal Application",
            "type": "varchar",
            "len": 255,
            "comment": "Reference to the portal",
            "name": "portal_app",
            "source": {
                "type": "db"
            }
        },
        "invalid_email": {
            "vname": "Invalid Email",
            "type": "bool",
            "comment": "Indicator that contact email address is invalid",
            "name": "invalid_email",
            "source": {
                "type": "db"
            }
        },
        "partner": {
            "type": "ref",
            "vname": "Partner",
            "bean_name": "Partner",
            "massupdate": true,
            "audited": true,
            "name": "partner",
            "detail_link": true,
            "source": {
                "type": "non-db"
            },
            "id_name": "partner_id"
        },
        "partner_id": {
            "name": "partner_id",
            "type": "id",
            "reportable": false,
            "inferred": true,
            "for_ref": "partner",
            "audited": true,
            "vname": "ID",
            "dbType": "char",
            "charset": "ascii",
            "len": 36,
            "editable": false,
            "source": {
                "type": "db"
            }
        },
        "campaign": {
            "comment": "Campaign that generated lead",
            "vname": "Campaign",
            "rname": "id",
            "id_name": "campaign_id",
            "type": "ref",
            "table": "campaigns",
            "isnull": true,
            "module": "Campaigns",
            "massupdate": false,
            "duplicate_merge": "disabled",
            "bean_name": "Campaign",
            "name": "campaign",
            "detail_link": true,
            "source": {
                "type": "non-db"
            }
        },
        "campaign_id": {
            "name": "campaign_id",
            "type": "id",
            "reportable": false,
            "inferred": true,
            "for_ref": "campaign",
            "vname": "ID",
            "isnull": true,
            "dbType": "char",
            "charset": "ascii",
            "len": 36,
            "editable": false,
            "source": {
                "type": "db"
            }
        },
        "vcard_size": {
            "type": "int",
            "comment": "Size of vCard",
            "duplicate_merge": "disabled",
            "reportable": false,
            "name": "vcard_size",
            "source": {
                "type": "db"
            }
        },
        "vcard": {
            "type": "text",
            "comment": "Pre-generated vCard for contact",
            "duplicate_merge": "disabled",
            "reportable": false,
            "name": "vcard",
            "multiline": true,
            "source": {
                "type": "db"
            }
        },
        "vcard_uri": {
            "type": "varchar",
            "len": 255,
            "comment": "URI generated by external contacts app",
            "reportable": false,
            "duplicate_merge": "disabled",
            "name": "vcard_uri",
            "source": {
                "type": "db"
            }
        },
        "photo": {
            "vname": "Photo",
            "type": "image",
            "placeholder": "themes\/Default\/images\/no_user.png",
            "alt_image": "primary_account.photo",
            "name": "photo",
            "source": {
                "type": "non-db"
            },
            "display_size": [
                90,
                90
            ],
            "thumbnail_size": [
                120,
                120,
                1
            ],
            "thumbnail": "auto",
            "max_size": 1000,
            "upload_dir": "{FILES}\/images\/photos\/",
            "filename": "photo_filename",
            "thumbnail_name": "photo_thumb"
        },
        "photo_filename": {
            "vname": "Photo Filename",
            "type": "file_ref",
            "name": "photo_filename",
            "size": 255,
            "reportable": false,
            "source": {
                "type": "db"
            }
        },
        "photo_thumb": {
            "vname": "Thumbnail Filename",
            "type": "file_ref",
            "name": "photo_thumb",
            "size": 255,
            "reportable": false,
            "source": {
                "type": "db"
            }
        },
        "chat_activity": {
            "type": "bool",
            "vname": "Chat Activity",
            "vname_module": "Chats",
            "default": 0,
            "name": "chat_activity",
            "source": {
                "type": "db"
            }
        },
        "mautic_id": {
            "type": "int",
            "vname": "Lead Guerrilla Contact ID",
            "vname_module": "LeadGuerrilla",
            "comment": "ID of related contact in Mautic\/Lead Guerrilla",
            "name": "mautic_id",
            "source": {
                "type": "db"
            }
        },
        "livechat_activity": {
            "type": "bool",
            "vname": "Live Chat Activity",
            "vname_module": "LiveChatInc",
            "default": 0,
            "name": "livechat_activity",
            "source": {
                "type": "db"
            }
        }
    },
    "filters": {
        "filter_text": {
            "name": "filter_text",
            "vname": "Search Text",
            "type": "unified_search",
            "basic": true,
            "fulltext_search": false,
            "search_what": "all",
            "report_filter": true,
            "quick_view": true
        },
        "filter_owner": {
            "vname": "Owner",
            "type": "owner",
            "default_value": "all",
            "options": {
                "all": {
                    "vname": "LBL_FILTER_OWNER_ANY",
                    "icon": "icon-users"
                },
                "mine": {
                    "field": "assigned_user_id",
                    "link": "",
                    "vname": "LBL_FILTER_OWNER_MINE",
                    "value": "1",
                    "icon": "icon-adminuser"
                },
                "not_mine": {
                    "field": "assigned_user_id",
                    "link": "",
                    "vname": "LBL_FILTER_OWNER_NOT_MINE",
                    "operator": "!=",
                    "value": "1",
                    "icon": "icon-users"
                },
                "select": {
                    "field": "assigned_user_id",
                    "link": "",
                    "vname": "LBL_FILTER_OWNER_SELECT",
                    "icon": "icon-popup"
                }
            },
            "options_icon": "icon",
            "options_blank_key": "all",
            "input_class": "OwnerSelect",
            "report_filter": true,
            "var_width": true,
            "basic": true
        },
        "filter_favorites": {
            "name": "filter_favorites",
            "vname": "Only Favorites",
            "type": "flag",
            "class": "check-star",
            "basic": true,
            "field": "favorites.deleted",
            "default_value": false,
            "operator": "eq",
            "value": "0"
        },
        "primary_account": {
            "vname": "Primary Account",
            "vname_list": "Account Name",
            "type": "ref",
            "bean_name": "Account",
            "importable": false,
            "massupdate": false,
            "audited": true,
            "name": "primary_account",
            "id_name": "primary_account_id",
            "vname_module": "Contacts",
            "field": "primary_account",
            "editable": true,
            "updateable": true,
            "allow_custom": true,
            "basic": true
        },
        "first_name": {
            "vname": "First Name",
            "type": "varchar",
            "len": 100,
            "comment": "First name of the contact",
            "name": "first_name",
            "vname_module": "Contacts",
            "field": "first_name",
            "editable": true,
            "updateable": true
        },
        "last_name": {
            "vname": "Last Name",
            "type": "name",
            "len": 100,
            "comment": "Last name of the contact",
            "name": "last_name",
            "dbType": "varchar",
            "vname_module": "Contacts",
            "field": "last_name",
            "editable": true,
            "updateable": true
        },
        "categories": {
            "vname": "Category",
            "vname_list": "Category",
            "type": "multienum",
            "options": {
                "Business": "Business",
                "Company Staff": "Company Staff",
                "Customers": "Customers",
                "Friends and Family": "Friends & Family",
                "Partners": "Partners",
                "Personal Services": "Personal Services",
                "Press and Analysts": "Press & Analysts",
                "Professional Advisors": "Professional Advisors",
                "Restaurants": "Restaurants",
                "Suppliers": "Suppliers"
            },
            "len": 40,
            "multi_select_group": "category",
            "multi_select_count": 10,
            "massupdate": true,
            "name": "categories",
            "dbType": "varchar",
            "charset": "ascii",
            "vname_module": "Contacts",
            "field": "categories",
            "editable": true,
            "updateable": true
        },
        "lead_source": {
            "vname": "Lead Source",
            "type": "enum",
            "options": {
                "Cold Call": "Cold Call",
                "Existing Customer": "Existing Customer",
                "Self Generated": "Self Generated",
                "Employee": "Employee",
                "Partner": "Partner",
                "Public Relations": "Public Relations",
                "Direct Mail": "Direct Mail",
                "Conference": "Conference",
                "Trade Show": "Trade Show",
                "Web Site": "Web Site",
                "Customer Portal": "Customer Portal",
                "Word of mouth": "Word of mouth",
                "Email": "Email",
                "Other": "Other"
            },
            "len": 100,
            "comment": "How did the contact come about",
            "massupdate": true,
            "name": "lead_source",
            "dbType": "varchar",
            "charset": "ascii",
            "vname_module": "Contacts",
            "field": "lead_source",
            "editable": true,
            "updateable": true
        },
        "do_not_call": {
            "vname": "Do Not Call",
            "type": "bool",
            "dbType": "varchar",
            "len": 3,
            "audited": true,
            "comment": "An indicator of whether contact can be called",
            "massupdate": true,
            "name": "do_not_call",
            "vname_module": "Contacts",
            "field": "do_not_call",
            "editable": true,
            "updateable": true
        },
        "any_phone": {
            "vname": "Any Phone",
            "type": "phone",
            "fields": [
                "phone_home",
                "phone_mobile",
                "phone_work",
                "phone_other",
                "phone_fax",
                "assistant_phone"
            ]
        },
        "any_email": {
            "vname": "Any Email",
            "type": "email",
            "fields": [
                "email1",
                "email2"
            ]
        },
        "assistant": {
            "vname": "Assistant",
            "type": "varchar",
            "len": 75,
            "unified_search": true,
            "comment": "Name of the assistant of the contact",
            "name": "assistant",
            "vname_module": "Contacts",
            "field": "assistant",
            "editable": true,
            "updateable": true
        },
        "email_opt_out": {
            "vname": "Email Opt Out",
            "type": "bool",
            "dbType": "varchar",
            "len": 3,
            "comment": "Indicator whether the contact has elected to opt out of\nemails",
            "massupdate": true,
            "name": "email_opt_out",
            "vname_module": "Contacts",
            "field": "email_opt_out",
            "editable": true,
            "updateable": true
        },
        "address_street": {
            "vname": "Any Address",
            "type": "varchar",
            "fields": [
                "primary_address_street",
                "alt_address_street"
            ]
        },
        "address_city": {
            "vname": "Any City",
            "type": "varchar",
            "fields": [
                "primary_address_city",
                "alt_address_city"
            ]
        },
        "address_state": {
            "vname": "Any State",
            "type": "varchar",
            "fields": [
                "primary_address_state",
                "alt_address_state"
            ]
        },
        "address_postalcode": {
            "vname": "Any Postal Code",
            "type": "varchar",
            "fields": [
                "primary_address_postalcode",
                "alt_address_postalcode"
            ]
        },
        "address_country": {
            "vname": "Any Country",
            "type": "varchar",
            "fields": [
                "primary_address_country",
                "alt_address_country"
            ]
        },
        "title": {
            "vname": "Title",
            "type": "varchar",
            "len": 50,
            "comment": "The title of the contact",
            "vname_list": "Title",
            "audited": true,
            "list_subtitle": true,
            "name": "title",
            "vname_module": "Contacts",
            "field": "title",
            "editable": true,
            "updateable": true
        },
        "business_role": {
            "vname": "Business Role",
            "type": "enum",
            "options": {
                "CEO": "CEO",
                "MIS": "MIS",
                "CFO": "CFO",
                "Sales": "Sales",
                "Admin": "Admin"
            },
            "len": 40,
            "massupdate": true,
            "audited": true,
            "name": "business_role",
            "dbType": "varchar",
            "charset": "ascii",
            "vname_module": "Contacts",
            "field": "business_role",
            "editable": true,
            "updateable": true
        }
    }
}
~~~~~~~~~~~~~
