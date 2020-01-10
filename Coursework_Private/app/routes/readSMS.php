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

$app->get('/readSMS', function(Request $request, Response $response) use ($app)
{
    $page_text  = 'Select a message to read';

    $html_output = $this->view->render($response,
        'readSMS.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'SMS messages',
            'page_text' => $page_text,
        ]);


    return $html_output;

})->setName('readSMS');

function retrieveStockquoteData2($app, $validated_company_symbol)
{

    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('sqlQueries');
    $companyDetailsModel = $app->getContainer()->get('companyDetailsModel');

    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $companyDetailsModel->setSqlQueries($sql_queries);
    $companyDetailsModel->setDatabaseConnectionSettings($database_connection_settings);
    $companyDetailsModel->setDatabaseWrapper($database_wrapper);

    $company_details = $companyDetailsModel->getCompanyStockData($validated_company_symbol);

    return $company_details;
}


function createChart2($app, array $company_stock_data)
{
    require_once 'libchart/classes/libchart.php';

    $companyDetailsChartModel = $app->getContainer()->get('companyDetailsChartModel');

    $companyDetailsChartModel->setStoredCompanyStockData($company_stock_data);
    $companyDetailsChartModel->createLineChart();
    $chart_details = $companyDetailsChartModel->getLineChartDetails();

    return $chart_details;
}
