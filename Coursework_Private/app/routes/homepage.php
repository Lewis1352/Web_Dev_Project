<?php
/**
 * homepage.php
 *
 * Homepage showing actions that can be taken
 *
 * Author: 18-3110-AP
 * */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * This is the landing page for the site
 */
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
            'readSMS' => LANDING_PAGE . '/downloadmessages',

        ]);


    return $html_output;

})->setName('homepage');
