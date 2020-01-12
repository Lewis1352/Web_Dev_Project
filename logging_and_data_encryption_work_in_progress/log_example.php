<?php
/**
 * Created by PhpStorm.
 * User: P16222897
 * Date: 12/01/2020
 * Time: 11:52
 */
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
require_once "logging.php";

$log_wrapper = new logging();

//create a monolog instance
$log_wrapper->create_log("default");


//create a handler for the logger instance default
$log_wrapper->create_handler("default","/p3t/test.log","info");





//unencrypt and obtain email password for sending error messages to email
//$email_info =array();
//$email_info = $log_wrapper->retrieve_email_creds($lock_data,$key_manager->get_key("email_login"));
$log_wrapper->create_email_handler("default","critical error");

//append log messages to log instance (note log messages appended to 'critical' will send the log message to the email account
$log_wrapper->log_message('default','error','x error occured');
$log_wrapper->log_message('default','critical','x error occured');











