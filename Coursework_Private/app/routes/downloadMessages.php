<?php
/**
 * downloadMessages.php
 *
 * Opens soap connection, pulls messages and stores into the database after parsing.
 *
 * Author: 18-3110-AP
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * When going to the /downloadmessages location the downloadMessageData function is ran
 * The return of downloadMessageData is then passed into the storeDownloadedMessageData function
 * Finally we are redirected to the /readSMS location
 */
$app->get('/downloadmessages', function(Request $request, Response $response) use ($app)
{
    $messageData = downloadMessageData($app);

    storeDownloadedMessageData($app,$messageData);

    return $response->withRedirect(LANDING_PAGE.'/readSMS', 303);
})->setName('downloadMessages');

/**
 * This function creates a soap client and downloads the data
 * If the soap client is created successfully the getSoapDatafunction will be ran using the parameters
 *
 * @param $app slim application
 * @return mixed raw xml of the downloaded messages
 */
function downloadMessageData($app)
{
    $soap_wrapper = $app->getContainer()->get('SoapClient');

    $soap_client = $soap_wrapper->createSoapClient();

    if (is_object($soap_client))
    {
        $soap_call_parameters =
            [
                'username' => '19_16216247',
                'password' => '89UQ6Mmtq18S',
                'count' => 0
            ];
        $webservice_value = '';

        $soap_wrapper->getSoapData($soap_call_parameters, $webservice_value);
    }

    return $soap_wrapper->downloaded_message_data['raw-xml'];
}

/**
 * This function is used to store the downloaded data into the database
 * Gets the database wrapper, sql commands, message model and settings from the slim application
 * Get the PDO settings for our databse connection
 * foreach through the array of messages
 * Applys the previous data got to our message model
 * Store the message data to the database
 *
 * @param $app slim application
 * @param $messageData raw xml of downloaded messages
 */
function storeDownloadedMessageData($app,$messageData)
{
    $store_data_result = null;

    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('sqlQueries');
    $messageModel = $app->getContainer()->get('messageModel');
    $messageModel->setSanitizer($app->getContainer()->get('XmlSanitizer'));

    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    foreach($messageData as $message){
        $messageContent = simplexml_load_string($message);
        if($messageContent->message->id == '18-3110-AP'){
            $messageModel->setSqlQueries($sql_queries);
            $messageModel->setDatabaseConnectionSettings($database_connection_settings);
            $messageModel->setDatabaseWrapper($database_wrapper);

            $messageModel->storeMessageData($messageContent);
        }
    }

    return $store_data_result;
}