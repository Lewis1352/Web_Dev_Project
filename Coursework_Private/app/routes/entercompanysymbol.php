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

$app->get('/entercompanysymbol', function(Request $request, Response $response) use ($app)
{

    $submit_button_text = 'Retrieve the company stock data >>>';

    $page_text  = 'Enter the 3-character company symbol for which you wish to download stock data from the stock exchange.';
    $page_text .= '<br>See <a href="http://www.eoddata.com/symbols.aspx">EOD Data</a> for a list of company symbols';
    $page_text .= '<p>Enter a company symbol, then select ' . $submit_button_text . '</p>';

    $html_output = $this->view->render($response,
        'entercompanysymbolform.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'method' => 'post',
            'action' => 'downloadstockdata',
            'initial_input_box_value' => null,
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Enter a company symbol',
            'submit_button_text' => $submit_button_text,
            'page_text' => $page_text,
        ]);

    $processed_output = processOutput($app, $html_output);

    return $processed_output;

})->setName('entercompanysymbol');
