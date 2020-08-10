\page ex-print-invoice Print an Invoice PDF

This is a basic example of printing a record PDF using 1CRM API.

~~~~~~~~~~~~~{.php}

//Set request options
$options = [
    'skip_body_parsing' => true
];

try {
    $model = 'Invoice';
    $invoice_id = '11520ebd-9496-3fdb-a833-5f2d5dee090c';

    $body = $client->request("GET", "/printer/pdf/{$model}/{$invoice_id}", $options);

    //Output PDF
    ob_get_clean();
    session_write_close();

    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="Invoice.pdf"');
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
