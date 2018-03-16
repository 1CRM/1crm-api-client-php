\page ex-quote-structure Reconstructing Quote structure

1CRM provides a number of modules representing what we call **Tally objects**. This
includes Quotes, Invoices, Bills, Sales Orders, Purchase Orders, Credit Notes,
Shipping and Receiving. They all have a common property: they contain a number of
line groups, and each group consists of a number of lines. Each line represents
a product, a service, an expense or a comment. Also, a group can contain a number
of *adjustments* such as taxes, discounts etc.  Each adjustment can apply to 
individual line item or to whole group.

We at 1CRM are working to add special methods to the REST API to make using the  API
with Tally objects easier, but currently you have to use general API requests to access
information about Quotes, Invoices etc.

The structure of Tally object may be a bit complicated and you need some time 
and effort to understand it. Data is scattered across several database tables - in fact,
there are 5 tables for each kind of Tally object: the tally record itself, line groups,
line items, comments and adjustments. Groups, lines, comments and adjustments have a
"position" field that allows to place them in correct order when reconstructing 
quote structure. 

First, you get list of groups:

~~~~~~~~~~~~~{.php}
$model = $client->model('Quote');
$quote_id = '6b39fc26-3330-fd5b-a592-5aa798039309';
$result = $model->getRelated($quote_id, 'line_groups_link');
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

~~~~~~~~~~~~~
[
    {
        "name": "Group 1",
        "id": "6b6b0438-cd4a-0990-423b-5aa7988d4d4a",
        "_display": "Group 1"
    },
    {
        "name": "Group 2",
        "id": "67dedd63-344a-4582-af46-5aab714aa5d6",
        "_display": "Group 2"
    }
]
~~~~~~~~~~~~~

Then, obtain lines:

~~~~~~~~~~~~~{.php}
$model = $client->model('Quote');
$line_fields = ['position', 'line_group_id'];
$quote_id = '6b39fc26-3330-fd5b-a592-5aa798039309';
$result = $model->getRelated($quote_id, 'lines_link', ['fields' => $line_fields]);
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

~~~~~~~~~~~~~
[
    {
        "position": "9",
        "line_group_id": "67dedd63-344a-4582-af46-5aab714aa5d6",
        "id": "67e184ad-0f64-74c4-a160-5aab7191a45c",
        "name": "HP LaserJet Pro M476DW MFP ",
        "_display": "HP LaserJet Pro M476DW MFP "
    },
    {
        "position": "4",
        "line_group_id": "6b6b0438-cd4a-0990-423b-5aa7988d4d4a",
        "id": "6b6e15d9-9954-8fa1-c076-5aa79845ea9c",
        "name": "Retina MacBook 12\" 512GB",
        "_display": "Retina MacBook 12\" 512GB"
    },
    {
        "position": "14",
        "line_group_id": "6b6b0438-cd4a-0990-423b-5aa7988d4d4a",
        "id": "6b6d0e2e-d182-b6bd-3fde-5aa798c62cd2",
        "name": "iPad Air 2 \/ 64 GB \/ Gold",
        "_display": "iPad Air 2 \/ 64 GB \/ Gold"
    }
]
~~~~~~~~~~~~~

and comments:

~~~~~~~~~~~~~{.php}
$model = $client->model('Quote');
$comment_fields = ['position', 'line_group_id', 'body'];
$quote_id = '6b39fc26-3330-fd5b-a592-5aa798039309';
$result = $model->getRelated($quote_id, 'comments_link', ['fields' => $comment_fields]);
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

~~~~~~~~~~~~~
[
    {
        "position": "4",
        "line_group_id": "67dedd63-344a-4582-af46-5aab714aa5d6",
        "body": "This is another comment",
        "id": "67e2de92-b449-c9b5-49dc-5aab71d5e786",
        "name": null,
        "_display": null
    },
    {
        "position": "9",
        "line_group_id": "6b6b0438-cd4a-0990-423b-5aa7988d4d4a",
        "body": "This is a comment",
        "id": "e7905680-bfc7-6151-2a31-5aab70fce466",
        "name": null,
        "_display": null
    }
]
~~~~~~~~~~~~~


After these requests, we can see that the quote contains 2 groups. In 1st group, 
we have **Retina macbook**, **This is a comment**, and **iPad Air**, and the second group 
contains **This is another comment** and **HP LaserJet**, exactly in that order if you 
sort by `position` field.

And now come the adjustments

~~~~~~~~~~~~~{.php}
$model = $client->model('Quote');
$adj_fields = ['position', 'line_group_id', 'line_id', 'related_type', 'type', 'related_id'];
$quote_id = '6b39fc26-3330-fd5b-a592-5aa798039309';
$result = $model->getRelated($quote_id, 'adjustments_link', ['fields' => $adj_fields]);
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

~~~~~~~~~~~~~
[
    {
        "position": "0",
        "line_group_id": "67dedd63-344a-4582-af46-5aab714aa5d6",
        "line_id": null,
        "related_type": "ShippingProviders",
        "type": "UntaxedShipping",
        "related_id": null,
        "id": "67e59e5c-400e-5148-7296-5aab71217ffe",
        "name": null,
        "_display": null
    },
    {
        "position": "0",
        "line_group_id": "6b6b0438-cd4a-0990-423b-5aa7988d4d4a",
        "line_id": null,
        "related_type": "Discounts",
        "type": "StandardDiscount",
        "related_id": "b6cbc17e-8d2a-5d06-a0d9-5aa798d23108",
        "id": "6b6f1541-5ddf-d55f-ada8-5aa798d86f27",
        "name": "Preferred Customer",
        "_display": "Preferred Customer"
    },
    {
        "position": "1",
        "line_group_id": "6b6b0438-cd4a-0990-423b-5aa7988d4d4a",
        "line_id": "6b6e15d9-9954-8fa1-c076-5aa79845ea9c",
        "related_type": "Discounts",
        "type": "StdPercentDiscount",
        "related_id": "af2aa23a-17b7-4ed8-4bcb-5aa7984efed5",
        "id": "8e2f1ca0-a5ee-b6c0-583e-5aab78a14bbd",
        "name": null,
        "_display": null
    },
    {
        "position": "2",
        "line_group_id": "6b6b0438-cd4a-0990-423b-5aa7988d4d4a",
        "line_id": null,
        "related_type": "TaxRates",
        "type": "StandardTax",
        "related_id": "84e86b71-ba97-6845-b8f9-5aa79860d367",
        "id": "8e3146d5-d59f-a3d6-2656-5aab788f2b81",
        "name": "HST",
        "_display": "HST"
    },
    {
        "position": "3",
        "line_group_id": "6b6b0438-cd4a-0990-423b-5aa7988d4d4a",
        "line_id": null,
        "related_type": "ShippingProviders",
        "type": "UntaxedShipping",
        "related_id": "d2dcb774-af3d-9702-d2c7-5aa7988181ed",
        "id": "6b6fe0fa-718b-e46e-ae9c-5aa798393ba2",
        "name": null,
        "_display": null
    }
]
~~~~~~~~~~~~~

What can we learn from this information? Both groups have shipping specified.
First group has Preferred customer discount and HST tax applied. Also, Retina Macbook
has a Discount.

Depending on what you want to achieve, you may need to fetch more fields  - only most 
common fields are shown here, for brevity.

The best way to understand how all parts fit together is to make changes
to a quote using 1CRM UI, and see how the cahnges affect the API output.
