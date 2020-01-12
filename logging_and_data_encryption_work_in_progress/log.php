<?php


require_once('logging.php');
require_once('lock_data.php');
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log_wrapper = new logging();

//create a monolog instance
$log_wrapper->create_log("default");


//create a handler for the logger instance default
$log_wrapper->create_handler("default","/p3t/test.log","info");


//create an lockdata instance to encrypt/decrypt data
$lock_data = new lockData();


//keys
$lock_data->generate_key("email_login");

//unencrypt and obtain email password for sending error messages to email
//$email_info =array();
//$email_info = $log_wrapper->retrieve_email_creds($lock_data,$key_manager->get_key("email_login"));
$log_wrapper->create_email_handler("default",$email_info,"critical error");

//append log messages to log instance (note log messages appended to 'critical' will send the log message to the email account
$log_wrapper->log_message('default','error','x error occured');
$log_wrapper->log_message('default','critical','x error occured');




   



