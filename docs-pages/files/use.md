\page files-use Using uploaded files

After a file is uploaded, you can use temporary file ID as a value
for fields of `file_ref` or `image` type


### Setting Account photo

~~~~~~~~~~~~~{.php}
$model = $client->model('Account');
$files = $client->files();

$res = fopen('/tmp/1crm_account_logo.png', 'r');
$fileId = $files->upload($res, 'logo.png', 'image.png');

$result = $model->update('967e8d65-1665-6b67-7ad2-5a8fc2287a44', ['photo' => $fileId]);

echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
true
~~~~~~~~~~~~~

### Creating a Document

~~~~~~~~~~~~~{.php}
$model = $client->model('Document');
$files = $client->files();

$res = fopen('/tmp/tempfile.txt', 'r');
$fileId = $files->upload($res, 'file.txt', 'text/plain');

$result = $model->create(['document_name' => 'Text Document', 'revision_filename' => $fileId]);

echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
"2f5d6dec-e1c5-e7c1-33f9-5a9119971946"
~~~~~~~~~~~~~

### Creating a Document revision

~~~~~~~~~~~~~{.php}
$model = $client->model('DocumentRevision');
$files = $client->files();

$res = fopen('/tmp/tempfile.txt', 'r');
$fileId = $files->upload($res, 'file.txt', 'text/plain');

$result = $model->create([
    'document_id' => '2f5d6dec-e1c5-e7c1-33f9-5a9119971946',
    'filename' => $fileId
]);

echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
"e9a27ddb-8240-c9b5-83d6-5a911acc7334"
~~~~~~~~~~~~~

### Creating a Note with attachment

~~~~~~~~~~~~~{.php}
$model = $client->model('Note');
$files = $client->files();

$res = fopen('/tmp/tempfile.txt', 'r');
$fileId = $files->upload($res, 'file.txt', 'text/plain');

$result = $model->create([
    'name' => 'Note with attachment',
    'description' => 'Note with attached file',
    'filename' => $fileId
]);

echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
"a6821be0-5467-a2d8-8a55-5a911bcfc186"
~~~~~~~~~~~~~

