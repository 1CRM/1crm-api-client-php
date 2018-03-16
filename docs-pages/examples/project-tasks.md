\page ex-project-tasks Get list of project tasks in a project

Most records in 1CRM have other related recors linked to them. 
For example, Contact can have a number of related accounts, and Project
can have multiple project tasks.  To fetch a list of related records,
use the [Model::getRelated()](@ref OneCRM::APIClient::Model::getRelated())
method. It returns an instance of [ListResult](@ref OneCRM::APIClient::ListResult)
class.

[Model::getRelated()](@ref OneCRM::APIClient::Model::getRelated()), similar to
[Model::getList()](@ref OneCRM::APIClient::Model::getList()), accepts 'fields',
'filters' and 'order' options - see other examples.

~~~~~~~~~~~~~{.php}
$model = $client->model('Project');
$project_id = '79ae14b8-5f03-cf4a-c986-5aa7988a6119';
$fields = ['name', 'date_due', 'status'];
$link_name = 'project_tasks';
$result = $model->getRelated($project_id, $link_name, ['fields' => $fields], 0, 5);
printf("There are %d project tasks in total\n", $result->totalResults());
echo json_encode($result->getRecords(), JSON_PRETTY_PRINT), "\n";
~~~~~~~~~~~~~

Output:

~~~~~~~~~~~~~
There are 11 project tasks in total
[
    {
        "name": "Conceptualization",
        "date_due": "2018-03-08",
        "status": "In Progress",
        "id": "8ac8c990-99cb-9933-b58e-5aa798ff7bfd",
        "_display": "Conceptualization"
    },
    {
        "name": "Brainstorming",
        "date_due": "2018-03-04",
        "status": "In Progress",
        "id": "ade37d77-2884-1d80-414e-5aa7980944c0",
        "_display": "Brainstorming"
    },
    {
        "name": "Specifications",
        "date_due": "2018-03-08",
        "status": "In Progress",
        "id": "aff39b25-f394-33d6-9d48-5aa79885ad61",
        "_display": "Specifications"
    },
    {
        "name": "Engineering",
        "date_due": "2018-03-23",
        "status": "Deferred",
        "id": "b1cae5c5-fdfe-91cc-a023-5aa7985e429a",
        "_display": "Engineering"
    },
    {
        "name": "Design",
        "date_due": "2018-03-14",
        "status": "Pending Input",
        "id": "b36e1762-35f0-3570-4d4c-5aa7987eb4f0",
        "_display": "Design"
    }
]
~~~~~~~~~~~~~
