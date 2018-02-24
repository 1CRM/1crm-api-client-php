\page files-upload Uploading files

Use [Files::upload()](@ref OneCRM::APIClient::Files::upload) method to upload
a file to temporary location. This method returns uploaded file ID.

When uploading a file, you specify file name, file contents and optional file content type.

File contents can be specified in a number of ways:

#### using a string

~~~~~~~~~~~~~{.php}
$files = $client->files();
$result = $files->upload('this is the contents of a text file', 'file.txt', 'text/plain');
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
"INCOMING~41e9ee12-de45-4488-e8ab-5a9114476b58"
~~~~~~~~~~~~~

#### using a file resource 

~~~~~~~~~~~~~{.php}
$files = $client->files();
$res = fopen('/tmp/tempfile.txt', 'r');
$result = $files->upload($res, 'file.txt', 'text/plain');
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
"INCOMING~6cfe1dc9-4c29-adef-a415-5a91149de523"
~~~~~~~~~~~~~

#### using a stream resource 

~~~~~~~~~~~~~{.php}
$files = $client->files();
$stream = new GuzzleHttp\Psr7\Stream(fopen('/tmp/tempfile.txt', 'r'));
$result = $files->upload($stream, 'file.txt', 'text/plain');
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
"INCOMING~6cfe1dc9-4c29-adef-a415-5a91149de523"
~~~~~~~~~~~~~
