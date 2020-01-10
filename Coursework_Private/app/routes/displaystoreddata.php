<?php
/**
 * Created by PhpStorm.
 * User: cfi
 * Date: 20/11/15
 * Time: 14:01
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/displaystoreddata',
    function(Request $request, Response $response) use ($app)
    {
        $tainted_parameters = $request->getParsedBody();

        $validated_company_symbol = validateCompanySymbol($app, $tainted_parameters);

        $company_details = retrieveStockquoteData($app, $validated_company_symbol);
        $company_name = $company_details['company-name'];
        $company_stock_data_set = $company_details['company-retrieved-data'];

        $chart_location = createChart($app, $company_details);

        $html_output = $this->view->render($response,
            'displaystoreddata.html.twig',
            [
                'css_path' => CSS_PATH,
                'landing_page' => 'selectcompanytodisplay',
                'initial_input_box_value' => null,
                'page_title' => APP_NAME,
                'page_heading_1' => APP_NAME,
                'page_heading_2' => 'Result',
                'company_data_set' => $company_stock_data_set,
                'chart_location' => $chart_location,
                'company_name' => $company_name,
            ]);

        $processed_output = processOutput($app, $html_output);

        return $processed_output;
    });

/*
function createChart($app, array $company_stock_data)
{
    require_once 'libchart/classes/libchart.php';

    $companyDetailsChartModel = $app->getContainer()->get('companyDetailsChartModel');

    $companyDetailsChartModel->setStoredCompanyStockData($company_stock_data);
    $companyDetailsChartModel->createLineChart();
    $chart_details = $companyDetailsChartModel->getLineChartDetails();

    return $chart_details;
}
*/
function validateCompanySymbol($app, array $tainted_parameters): string
{
    $validator = $app->getContainer()->get('validator');
    $validated_company_symbol = $validator->validateCompanySymbol($tainted_parameters['company_symbol']);
    return $validated_company_symbol;
}

function retrieveStockquoteData($app, $validated_company_symbol)
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
