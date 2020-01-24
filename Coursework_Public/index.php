<?php
/** index.php
	* PHP program to demonstrate the usage of a soap server
	*/

use \Coursework\logging;

require 'vendor/autoload.php';

$make_trace = false;

ini_set('display_errors', 'On');
ini_set('html_errors', 'On');
ini_set('xdebug.trace_output_name', 'Coursework.%t');

//$logs_file_path = '/home/p16216247/logs/';
//$logs_file_name = 'coursework.log';
//$logs_file = $logs_file_path . $logs_file_name;

$log_wrapper = new logging();
//create a monolog instance
$log_wrapper->create_log("default");
//create a handler for the logger instance default
//$log_wrapper->create_handler("default", $logs_file, "info");

$log_wrapper->create_email_handler("default","critical error");

//append log messages to log instance (note log messages appended to 'critical' will send the log message to the email account
$log_wrapper->log_message('default','error','x error occured');
$log_wrapper->log_message('default','critical','x error occured');

if ($make_trace == true && function_exists(xdebug_start_trace()))
{
    xdebug_start_trace();
}

include 'Coursework_Private/bootstrap.php';

if ($make_trace == true && function_exists(xdebug_stop_trace()))
{
    xdebug_stop_trace();
}
