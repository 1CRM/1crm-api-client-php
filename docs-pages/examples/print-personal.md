\page ex-print-personal Print a Contact Personal Data PDF

This is a basic example of printing a personal data PDF using 1CRM API.

~~~~~~~~~~~~~{.php}

//Set request options
$options = [
    'skip_body_parsing' => true
];

try {
    $model = 'Contact';
    $contact_id = '8ccb3aaa-3bab-5bbc-4ca4-5c9b2502940f';

    $body = $client->request("GET", "/printer/pdf/personal/{$model}/{$contact_id}", $options);

    //Output PDF
    ob_get_clean();
    session_write_close();

    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="PersonalData.pdf"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');

    while (! $body->eof()) {
        $data = $body->read(16384);
        echo $data;
    }
    exit;
} catch (Exception $e) {
    printf(
        "Exception with code %d. %s.\n",
        $e->getCode(), $e->getMessage()
    );
}
~~~~~~~~~~~~~
