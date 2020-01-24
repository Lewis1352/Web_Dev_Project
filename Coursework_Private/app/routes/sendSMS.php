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

$app->get('/sendSMS', function(Request $request, Response $response) use ($app)
{
    $html_output = $this->view->render($response,
        'sendSMS.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Send SMS messages',
        ]);

    return $html_output;
})->setName('sendSMS');

$app->post('/sendSMSPost', function(Request $request, Response $response) use ($app)
{
    $parameters = $request->getParsedBody();

    if(!validateRequest($app, $parameters)){
        return $response->withRedirect(LANDING_PAGE.'/sendSMS');
    }

    sendSMS($app,$parameters);

    return $response->withRedirect(LANDING_PAGE.'/');
})->setName('sendSMSPost');

function sendSMS($app,$parameters){
    $xml = '';
    $parameters['id'] = '18-3110-AP';

    foreach($parameters as $tag => $parameter){
        $xml .= '<'.$tag.'>' . $parameter . '</' . $tag . '>';
    }

    $soap_wrapper = $app->getContainer()->get('SoapClient');

    $soap_client = $soap_wrapper->createSoapClient();

    if (is_object($soap_client))
    {
        $soap_call_parameters =
            [
                'username' => '19_16216247',
                'password' => '89UQ6Mmtq18S',
                'deviceMSISDN' => '447817814149',
                'message' => $xml,
                'deliveryReport' => 0,
                'mtBearer' => 'SMS'
            ];
        $webservice_value = '';

        $soap_wrapper->sendSMS($soap_call_parameters, $webservice_value);
    }

}

function validateRequest($app, array $tainted_parameters)
{
    $validator = $app->getContainer()->get('validator');

    return $validator->validateSwitch($tainted_parameters['s1']) &&
    $validator->validateSwitch($tainted_parameters['s2']) &&
    $validator->validateSwitch($tainted_parameters['s3']) &&
    $validator->validateSwitch($tainted_parameters['s4']) &&
    $validator->validateKeypad($tainted_parameters['keypad']) &&
    $validator->validateFan($tainted_parameters['fan']) &&
    $validator->validateHeater($tainted_parameters['heater']);
}
