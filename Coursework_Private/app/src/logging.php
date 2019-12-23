<?php

require_once('/p3t/phpappfolder/includes/vendor/autoload.php');
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


	//functions
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
		}
	}

	function Email_Alert()
	{
		//create the transport
		$transporter = new Swift_SmtpTransport('smtp.gmail.com',465,'ssl');;
		//work in progress...

	}	
}
