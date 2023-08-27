<?php

/**
 * A basic example of creating a 1CRM client script using .env
 */
use OneCRM\APIClient\Authentication\Basic;
use OneCRM\APIClient\Client;
use OneCRM\APIClient\Error as OneCRMError;

require 'vendor/autoload.php';

//Load environment vars, checks in current dir for a .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//Set up a client
$auth = new Basic($_ENV['ONECRM_USERNAME'], $_ENV['ONECRM_PASSWORD']);
$client = new Client($_ENV['ONECRM_ENDPOINT'], $auth);

//Call an API endpoint
try {
    echo json_encode($client->me(), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
} catch (ValueError $e) {
    echo 'Invalid JSON response: ', $e->getMessage();
} catch (OneCRMError $e) {
    echo '1CRM error: ', $e->getMessage();
}
