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

    //$submit_button_text = 'Retrieve the company stock data >>>';

    $page_text  = 'Select a message to read';
    //$page_text .= '<br>See <a href="http://www.eoddata.com/symbols.aspx">EOD Data</a> for a list of company symbols';
    //$page_text .= '<p>Enter a company symbol, then select ' . $submit_button_text . '</p>';

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
