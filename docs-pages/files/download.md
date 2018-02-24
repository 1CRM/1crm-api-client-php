\page files-download Downloading files

To download a file attached to Document, DocumentRevision or Note, 
use [Files::download()](@ref OneCRM::APIClient::Files::download) method.

~~~~~~~~~~~~~{.php}
$files = $client->files();

$result = (string)$files->download('Document', '2f5d6dec-e1c5-e7c1-33f9-5a9119971946');
echo json_encode($result, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
"This is the contents of text file!!!\n"
~~~~~~~~~~~~~

[Files::download()](@ref OneCRM::APIClient::Files::download) returns an instance of
`GuzzleHttp\Psr7\Stream` class. You can simply cast the stream to a string, as in
example above. If you want to save to a file, you can pass an additional argument to
[Files::download()](@ref OneCRM::APIClient::Files::download):


~~~~~~~~~~~~~{.php}
$files = $client->files();

// --- either ------

$files->download('Document', '2f5d6dec-e1c5-e7c1-33f9-5a9119971946', '/tmp/destination.txt');

// --- or ------

$fh = fopen('/tmp/destination.txt', 'w');
$files->download('Document', '2f5d6dec-e1c5-e7c1-33f9-5a9119971946', $fh);

// at this point, $fh is still open!
~~~~~~~~~~~~~
