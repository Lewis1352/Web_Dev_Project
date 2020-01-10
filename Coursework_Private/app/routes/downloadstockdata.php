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
    $company_symbols = downloadStockData($app);

    $company_stock_data = '';
    $submit_button_text = 'Another Company >>>';
    $company_symbols = [];

    $html_output = $this->view->render($response,
        'downloadedstockdataform.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'method' => 'post',
            'action' => 'displaystockquotedetails',
            'initial_input_box_value' => null,
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Display downloaded stock quote data',
            'company_stock_datanames' => $company_stock_data,
            'company_symbol' => $validated_company_symbol,
            'submit_button_text' => $submit_button_text,
            'page_text' => $submit_button_text,
            'route' => 'entercompanysymbol',
        ]);

    $processed_output = new \Coursework\processOutput($app, $html_output);

    return $processed_output;

})->setName('downloadstockdata');

function downloadStockData($app)
{
    $company_stock_data = [];

    $soap_wrapper = $app->getContainer()->get('SoapClient');

    $soap_client = $soap_wrapper->createSoapClient();

    if (is_object($soap_client))
    {
        $soap_call_function = 'peakMessages';
        $soap_call_parameters =
            [

            ];
        $webservice_value = '';

        $soap_wrapper->getSoapData($soap_client, $soap_call_function, $soap_call_parameters, $webservice_value);
    }

    var_dump($company_stock_data); die('');
    return $company_stock_data;
}

function storeDownloadedStockData($app, $validated_company_symbol)
{
    $store_data_result = null;

    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('sqlQueries');
    $companyDetailsModel = $app->getContainer()->get('companyDetailsModel');

    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $companyDetailsModel->setSqlQueries($sql_queries);
    $companyDetailsModel->setDatabaseConnectionSettings($database_connection_settings);
    $companyDetailsModel->setDatabaseWrapper($database_wrapper);

//    $store_data_result = $companyDetailsModel->getCompanySymbols();
    return $store_data_result;
}