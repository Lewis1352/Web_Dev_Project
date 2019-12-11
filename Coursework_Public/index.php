<?php
/** index.php
	* PHP program to demonstrate the usage of a soap server
	*/

$make_trace = false;

ini_set('display_errors', 'On');
ini_set('html_errors', 'On');
ini_set('xdebug.trace_output_name', 'SoapClient.%t');

if ($make_trace == true && function_exists(xdebug_start_trace()))
{
    xdebug_start_trace();
}

include 'Coursework_Private/bootstrap.php';

if ($make_trace == true && function_exists(xdebug_stop_trace()))
{
    xdebug_stop_trace();
}
