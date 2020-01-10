<?php
/**
 * Created by PhpStorm.
 * User: slim
 * Date: 24/10/17
 * Time: 10:01
 */

namespace Coursework;

class CompanyDetailsModel
{
    private $database_wrapper;
    private $database_connection_settings;
    private $sql_queries;

    public function __construct(){}

    public function __destruct(){}

    public function setDatabaseWrapper($database_wrapper)
    {
        $this->database_wrapper = $database_wrapper;
    }

    public function setDatabaseConnectionSettings($database_connection_settings)
    {
        $this->database_connection_settings = $database_connection_settings;
    }

    public function setSqlQueries($sql_queries)
    {
        $this->sql_queries = $sql_queries;
    }

    public function getCompanySymbols()
    {
        $company_symbols = [];
        $query_string = $this->sql_queries->getAllCompanySymbols();
        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

        $this->database_wrapper->makeDatabaseConnection();

        $this->database_wrapper->safeQuery($query_string);

        $number_of_company_symbols = $this->database_wrapper->countRows();
        if ($number_of_company_symbols > 0)
        {
            while ($row = $this->database_wrapper->safeFetchArray())
            {
                $company_symbol = $row['stock_company_symbol'];
                $company_name = $row['stock_company_name'];
                $company_symbols[$company_symbol] = $company_name . ' (' . $company_symbol . ')';
            }
        }
        else
        {
            $company_symbols[0] = 'No companies found';
        }
        return $company_symbols;
    }


    public function getMessageData()
    {
        $messages = [];
        $message_id = '';
        $company_stock_values_list = [];

        $query_string = $this->sql_queries->getMessageData();
        #$query_parameters = [':stock_company_symbol' => $validated_company_symbol];

        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

        $this->database_wrapper->makeDatabaseConnection();

        $this->database_wrapper->safeQuery($query_string);

        $number_of_data_sets = $this->database_wrapper->countRows();

        if ($number_of_data_sets > 0)
        {
            $lcv = 0;
            while ($row = $this->database_wrapper->safeFetchArray())
            {
                $message_id = $row['id'];
                $company_stock_values_list[$lcv]['received_date'] = $row['received_date'];
                $company_stock_values_list[$lcv++]['content'] = $row['content'];
            }
        }
        else
        {
            $messages[0] = 'No messages found';
        }

        #$messages['$company_symbol'] = $validated_company_symbol;
        $messages['id'] = $message_id;
        $messages['company-data-sets'] = $number_of_data_sets;
        $messages['company-retrieved-data'] = $company_stock_values_list;

        return $messages;
    }

    public function storeMessageData($message){
        $messageContent = simplexml_load_string($message);

        if($messageContent->message->id == '18-3110-AE'){
            $query_string = $this->sql_queries->storeMessageData();
            $query_parameters = [
                ':message_received_date' => date("Y-m-d H:i:s", strtotime($messageContent->receivedtime) ),
                ':message_content' => $message
            ];

            $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

            $this->database_wrapper->makeDatabaseConnection();

            $this->database_wrapper->safeQuery($query_string, $query_parameters);
        }
    }

}