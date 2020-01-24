<?php
/**
 * readSMS.php
 *
 * Displays stored messages
 *
 * Author: 18-3110-AP
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * This is the the page used to display messages from the database
 */
$app->get('/readSMS', function(Request $request, Response $response) use ($app)
{
    $messages = retrieveMessageData($app);

    $html_output = $this->view->render($response,
        'readSMS.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'SMS messages',
            'get_messages' => LANDING_PAGE . '/downloadmessages',
            'messages' => $messages['message_data'],
        ]);

    return $html_output;
})->setName('readSMS');

/**
 * Function to get the message data from the database
 * Using settings from the slim application
 *
 * @param $app slim application
 * @return mixed message from database
 */
function retrieveMessageData($app)
{

    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('sqlQueries');
    $messageModel = $app->getContainer()->get('messageModel');

    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $messageModel->setSqlQueries($sql_queries);
    $messageModel->setDatabaseConnectionSettings($database_connection_settings);
    $messageModel->setDatabaseWrapper($database_wrapper);

    $messageDetails = $messageModel->getMessageData();

    return $messageDetails;
}

