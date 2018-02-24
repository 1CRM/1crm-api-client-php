\page files-info Get information about a file

For Documents, DocumentRevisions and Notes you can get information about attached
file using [Files::info()](@ref OneCRM::APIClient::Files::info) method.

### Information about Document

~~~~~~~~~~~~~{.php}
$files = $client->files();

$result = $files->info('Document', '2f5d6dec-e1c5-e7c1-33f9-5a9119971946');

echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "name": "file.txt",
    "size": 37,
    "mimetype": "text\/plain",
    "modified": 1519458962
}
~~~~~~~~~~~~~

\note
When getting information about a document, data for latest revision is returned

### Information about Document revision

~~~~~~~~~~~~~{.php}
$files = $client->files();

$result = $files->info('DocumentRevision', 'e9a27ddb-8240-c9b5-83d6-5a911acc7334');

echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "name": "file.txt",
    "size": 37,
    "mimetype": "text\/plain",
    "modified": 1519458962
}
~~~~~~~~~~~~~

### Information about Note

~~~~~~~~~~~~~{.php}
$files = $client->files();

$result = $files->info('Note', 'a6821be0-5467-a2d8-8a55-5a911bcfc186');

echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "name": "file.txt",
    "size": 37,
    "mimetype": "text\/plain",
    "modified": 1519459282
}
~~~~~~~~~~~~~
