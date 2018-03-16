\page ex-errors Error handling

\section general General information

If an error occurs during a API request, [Error](@ref OneCRM::APIClient::Error)
will be thrown. You can obtain additional information using getCode(), getType()
and getHint() methods. 

~~~~~~~~~~~~~{.php}
model = $client->model('Acount'); // note - typo in model name
try {
    $account_id = $model->create(['name' => 'New Account']);
    echo $account_id, "\n";
} catch (APIClient\Error $e) {
    printf(
        "Exception with code %d. %s. Type: %s. Hint: %s\n",
        $e->getCode(), $e->getMessage(), $e->getType(), $e->getHint()
    );
}
~~~~~~~~~~~~~

~~~~~~~~~~~~~
Exception with code 404. Model Acount not found. Type: . Hint:
~~~~~~~~~~~~~

\section network Network errors

If a network error occurs, an exception with code 0 will be thrown:

~~~~~~~~~~~~~{.php}
model = $client->model('Account');
try {
    $account_id = $model->create(['name' => 'New Account']);
    echo $account_id, "\n";
} catch (APIClient\Error $e) {
    printf(
        "Exception with code %d. %s. Type: %s. Hint: %s\n",
        $e->getCode(), $e->getMessage(), $e->getType(), $e->getHint()
    );
}
~~~~~~~~~~~~~

~~~~~~~~~~~~~
Exception with code 0. cURL error 6: Could not resolve host: demo.1crmcloud.com (see http://curl.haxx.se/libcurl/c/libcurl-errors.html). Type: . Hint:
~~~~~~~~~~~~~

\section codes Interpreting error codes


~~~~~~~~~~~~~{.php}
$model = $client->model('Account');
try {
    $account = $model->get('this-does-not-exist');
    var_dump($account);
} catch (APIClient\Error $e) {
    $code = $e->getCode();
    if (!$code) $reason = "This is a network error";
    elseif ($code == 400) $reason = "I sent a bad request"; 
    elseif ($code == 401) $reason = "I am not authorized"; 
    elseif ($code == 403) $reason = "The action I want to perform is forbidden"; 
    elseif ($code == 404) $reason = "What I am looking for does not exist"; 
    elseif ($code == 405) $reason = "The request method I used is not allowed"; 
    elseif ($code >= 400 && $code < 500) $reason = "I sent a bad request, not sure why :)"; // something wrong with our request
    elseif ($code >= 500 && $code < 600) $reason = "Server's bad"; // something wrong on the server side
    else $reason = "This should not happen"; // 1CRM API uses 4xx and 5xx error codes
    printf(
        "Exception with code %d. %s. %s. Type: %s. Hint: %s\n",
        $e->getCode(), $e->getMessage(), $reason, $e->getType(), $e->getHint()
    );
}
~~~~~~~~~~~~~

~~~~~~~~~~~~~
Exception with code 404. Not found. What I am looking for does not exist. Type: . Hint:
~~~~~~~~~~~~~
