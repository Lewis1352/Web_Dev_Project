<?php
/**
 * homepage.php
 *
 * Choose an action
 *
 * Author: CF Ingrams
 * Email: <cfi@dmu.ac.uk>
 * Date: 18/10/2015
 * */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function(Request $request, Response $response) use ($app) {

    $html_output = $this->view->render($response,
        'homepageform.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'method' => 'get',
            'action' => 'index.php',
            'initial_input_box_value' => null,
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_text' => 'Application will allow you to download stock data for a listed company, or to display pre-stored data.',
            'download_data' => LANDING_PAGE . '/entercompanysymbol',
            'selectcompanytodisplay' => LANDING_PAGE . '/selectcompanytodisplay',
        ]);

    $processed_output = processOutput($app, $html_output);

    return $processed_output;

})->setName('homepage');

function processOutput($app, $html_output)
{
    $process_output = $app->getContainer()->get('processOutput');
    $html_output = $process_output->processOutput($html_output);
    return $html_output;
}