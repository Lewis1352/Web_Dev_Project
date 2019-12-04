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

$app->get('/selectcompanytodisplay', function(Request $request, Response $response) use ($app)
{

    $company_symbols = retrieveCompanySymbols($app);

    $submit_button_text = 'Display the company history >>>';

    $html_output = $this->view->render($response,
        'selectcompanytodisplayform.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'method' => 'post',
            'action' => 'displaystoreddata',
            'initial_input_box_value' => null,
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Display details about a Company',
            'company_symbols' => $company_symbols,
            'submit_button_text' => $submit_button_text,
            'page_text' => 'Select a company name, then select ' . $submit_button_text,
        ]);

    $processed_output = processOutput($app, $html_output);

    return $processed_output;

})->setName('selectcompanytodisplay');


function retrieveCompanySymbols($app)
{
    $company_symbols = null;

    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('sqlQueries');
    $companyDetailsModel = $app->getContainer()->get('companyDetailsModel');

    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $companyDetailsModel->setSqlQueries($sql_queries);
    $companyDetailsModel->setDatabaseConnectionSettings($database_connection_settings);
    $companyDetailsModel->setDatabaseWrapper($database_wrapper);

    $company_symbols = $companyDetailsModel->getCompanySymbols();
    return $company_symbols;
}