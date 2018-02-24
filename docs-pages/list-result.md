\page list-result Working with results lists

[Model::getList()](@ref OneCRM::APIClient::Model::getList) and
[Model::getRelated()](@ref OneCRM::APIClient::Model::getRelated)
methods return  an instance of [ListResult](@ref OneCRM::APIClient::ListResult)
class. When calling these methods, API returns a limited number of record,
as specified by `$limit` argument. There may be more data available, and if you want
to retrieve it, you need to send additional requests, adjusting `$offset` argument
accordingly.

To get total number of results matching your request, call
[ListResult::totalResults()](@ref OneCRM::APIClient::ListResult::totalResults) : 

~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$result = $model->getList([], 0, 5);
echo $result->totalResults(), "\n";
echo count($result->getRecords()), "\n";
~~~~~~~~~~~~~

~~~~~~~~~~~~~
200
5
~~~~~~~~~~~~~

Although only 5 results were returned as we requested, we see that there is additional
data available. If you want to iterate over all results, and not a limited subset, you will 
need to send multiple requests. For example if there are 500 total results, and you fetch
the results in chunks of 100, you will need 5 requests:

Request #     | $offset     | $limit 
------------- | ------------| ------ 
1             | 0           | 100
2             | 100         | 100
3             | 200         | 100
4             | 300         | 100
5             | 400         | 100

[ListResult](@ref OneCRM::APIClient::ListResult) provides a `generator()` method that returns
a PHP generator for use in `foreach` loop. When iterating, it will send additional requests as
needed to iterate over all records:

~~~~~~~~~~~~~{.php}
$model = $client->model('Contact');
$result = $model->getList([], 0, 50);
echo "Call to getList() returned ", count($result->getRecords()), " results\n";
echo "In total, there are ", $result->totalResults(), " matching results\n";
$iteratedCount = 0;
foreach ($result->generator() as $record) {
    $iteratedCount++;;
}
echo "We iterated over ", $iteratedCount, " results\n";
~~~~~~~~~~~~~

~~~~~~~~~~~~~
Call to getList() returned 50 results
In total, there are 203 matching results
We iterated over 203 results
~~~~~~~~~~~~~
