<?php

/**
 * DatabaseWrapper.php
 *
 * Access the sessions database
 *
 * Author: 18-3110-AP
 */

namespace Coursework;

/**
 * Class DatabaseWrapper
 *
 * Used to interact with the database
 *
 * @package Coursework
 */
class DatabaseWrapper
{
    private $db_handle;
    private $sql_queries;
    private $prepared_statement;
    private $errors;
    private $database_connection_settings;

    /**
     * DatabaseWrapper constructor.
     */
    public function __construct()
    {
        $this->db_handle = null;
        $this->sql_queries = null;
        $this->prepared_statement = null;
        $this->errors = [];
    }

    /**
     * DatabaseWrapper destructor.
     */
    public function __destruct() { }

    /**
     * Set new database settings
     * @param $database_connection_settings new settings
     */
    public function setDatabaseConnectionSettings($database_connection_settings)
    {
        $this->database_connection_settings = $database_connection_settings;
    }

    /**
     *  Initialise database connection
     *  Uses PDO
     *  Gets settings from database_connection_settings
     *  Try catch for handling PDO errors
     *  @return string error message if applicable
     */
    public function makeDatabaseConnection()
    {
        $pdo = false;
        $pdo_error = '';

        $database_settings = $this->database_connection_settings;
        $host_name = $database_settings['rdbms'] . ':host=' . $database_settings['host'];
        $port_number = ';port=' . '3306';
        $user_database = ';dbname=' . $database_settings['db_name'];
        $host_details = $host_name . $port_number . $user_database;
        $user_name = $database_settings['user_name'];
        $user_password = $database_settings['user_password'];
        $pdo_attributes = $database_settings['options'];

        try
        {
            $pdo_handle = new \PDO($host_details, $user_name, $user_password, $pdo_attributes);
            $this->db_handle = $pdo_handle;
        }
        catch (\PDOException $exception_object)
        {
            trigger_error('error connecting to database');
            $pdo_error = 'error connecting to database';
        }

        return $pdo_error;
    }

    /**
     *
     */
    public function setLogger(){}

    /**
     * Used to perform an sql query with error handling
     * catch for PDO errors
     *
     * @param $query_string query to be performed
     * @param null $params extra parameters for query
     * @return mixed error message if applicable
     */
    public function safeQuery($query_string, $params = null)
    {
        $this->errors['db_error'] = false;
        $query_parameters = $params;

        try
        {
            $this->prepared_statement = $this->db_handle->prepare($query_string);
            $execute_result = $this->prepared_statement->execute($query_parameters);
            $this->errors['execute-OK'] = $execute_result;
        }
        catch (PDOException $exception_object)
        {
            $error_message  = 'PDO Exception caught. ';
            $error_message .= 'Error with the database access.' . "\n";
            $error_message .= 'SQL query: ' . $query_string . "\n";
            $error_message .= 'Error: ' . var_dump($this->prepared_statement->errorInfo(), true) . "\n";
            $this->errors['db_error'] = true;
            $this->errors['sql_error'] = $error_message;
        }
        return $this->errors['db_error'];
    }

    /**
     * Counts number of rows in prepare_statement
     * @return mixed rows in the prepared statement
     */
    public function countRows()
    {
        $num_rows = $this->prepared_statement->rowCount();
        return $num_rows;
    }

    /**
     * Fetches result from query
     * @return mixed array of result
     */
    public function safeFetchArray()
    {
        $arr_row = $this->prepared_statement->fetch(\PDO::FETCH_ASSOC);
        return $arr_row;
    }
}
