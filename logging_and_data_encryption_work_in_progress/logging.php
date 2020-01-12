<?php
/**
 * Created by PhpStorm.
 * User: P16222897
 * Date: 12/01/2020
 * Time: 11:33
 */
require_once "H:/p3t/phpappfolder/includes/vendor/autoload.php";

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SwiftMailerHandler;

class logging
{
    //properties
    var $log_instances;
    var $location;


    //constructor
    public function __construct()
    {
        $this->log_instances = [];
        $this->location = 0;
    }


    //get encrypted email password for sending email logs.
    /*function retrieve_email_creds($lock_data,$key)
    {
        //	$key = pass12
        $email_creds = include 'encrypted_email_information.txt';
       // $email = $lock_data->decrypt_string($email_creds[0],'aes-128-ctr',$key);
       // $password = $lock_data->decrypt_string($email_creds[1],'aes-128-ctr',$key);
        $creds = array($email,$password);
        return $creds;
    } */


    //create a log
    function create_log($channel_name)
    {
        $this->log_instances[$this->location] = new Logger($channel_name);
        $this->location++;
    }

    private	function get_log($channel_name)
    {
        foreach($this->log_instances as $log)
        {
            switch($log->getName())
            {
                case $channel_name:
                    return $log;
                    break;
            }
        }
    }

//	create handlers
    //need log_file name, logging tpe, and the log channel name
    function create_handler($channel_name,$log_path,$log_type)
    {
        $log_instance = $this->get_log($channel_name);

        switch($log_type)
        {

            case "debug": //detailed debugging info
                $log_instance->pushHandler(new streamhandler($log_path,Logger::DEBUG));
                break;
            case "info": //handles normal events such as SQL logs
                $log_instance->pushHandler(new streamhandler($log_path,Logger::INFO));
                break;
            case "notice": //handles normal events but with more importance
                $log_instance->pushHandler(new streamhandler($log_path,Logger::NOTICE));
                break;
            case "warning": //warning of potential error
                $log_instance->pushHandler(new streamhandler($log_path,Logger::WARNING));
                break;
            case "error": // an error occured
                $log_instance->pushhandler(new streamhandler($log_path,Logger::ERROR));
                break;
            case "critical": //critical potential danger
                $log_instance->pushhandler(new streamhandler($log_path,Logger::CRITICAL));
                break;
            case "alert": // immediate attention required
                $log_instance->pushhandler(new streamhandler($log_path,Logger::ALERT));
                break;
            case "emergency": // system is unusable
                $log_instance->pushhandler(new streamhandler($log_path,Logger::EMERGENCY));
                break;
        }
    }
    //create a message for logging
    function log_message($channel_name,$msg_type,$message)
    {
        $log_instance = $this->get_log($channel_name);

        switch($msg_type)
        {
            case "info":
                $log_instance->info($message);
                break;
            case "warning":
                $log_instance->warning($message);
                break;
            case "error":
                $log_instance->error($message);
                break;
            case "critical": //sends an email if there is an email handler attatched to logger
                $log_instance->critical($message);
                break;
        }
    }




    function create_email_handler($channel_log,/*$email_information*/$_message)
    {
        //	$transporter = new Swift_SmtpTransport('smtp.gmail.com',465,'ssl');
        $transporter = new Swift_SmtpTransport('smtp.zoho.eu',465,'ssl');
       // $transporter->setUsername($email_information[0]);
        //$transporter->setPassword($email_information[1]);
        $transporter->setUsername('WebXTeam2019@zohomail.eu');
        $transporter->setPassword('secure_web_applications_module');

        //create the mailer
        $mailer = new Swift_Mailer($transporter);

        //create the message
        $message = (new Swift_Message($_message));
       // $email = 'WebXTeam2019@zohomail.eu';
        $message->setFrom(['WebXTeam2019@zohomail.eu']);
        $message->setTo(['WebXTeam2019@zohomail.eu']);

        //create the handler
        $log_instance = $this->get_log($channel_log);
        $log_instance->pushHandler(new SwiftMailerHandler($mailer,$message,Logger::CRITICAL,false));

    }

}