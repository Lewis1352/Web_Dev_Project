<?php
/**
 * selectcompanytodisplay.php
 *
 * choose a stored company
 *
 * Author: CF Ingrams
 * Email: <cfi@dmu.ac.uk>
 * Date: 18/10/2015 *
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/downloadmessages', function(Request $request, Response $response) use ($app)
{
    $messageData = downloadMessageData($app);

    storeDownloadedMessageData($app,$messageData);

    return $response->withRedirect(LANDING_PAGE.'/readSMS', 303);
})->setName('downloadstockdata');

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

    return $soap_wrapper->downloaded_stockquote_data['raw-xml'];
}

function storeDownloadedMessageData($app,$messageData)
{
    $store_data_result = null;

    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('sqlQueries');
    $companyDetailsModel = $app->getContainer()->get('companyDetailsModel');

    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    foreach($messageData as $message){
        $companyDetailsModel->setSqlQueries($sql_queries);
        $companyDetailsModel->setDatabaseConnectionSettings($database_connection_settings);
        $companyDetailsModel->setDatabaseWrapper($database_wrapper);

        $companyDetailsModel->storeMessageData($message);
    }



//    $store_data_result = $companyDetailsModel->getCompanySymbols();
    return $store_data_result;
}