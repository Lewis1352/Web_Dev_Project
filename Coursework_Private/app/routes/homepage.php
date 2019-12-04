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
            'page_text' => 'This application will allow you to read and send sms messages',
            'download_data' => LANDING_PAGE . '/readSMS',
            'selectcompanytodisplay' => LANDING_PAGE . '/selectcompanytodisplay',
        ]);


    return $html_output;

})->setName('homepage');
