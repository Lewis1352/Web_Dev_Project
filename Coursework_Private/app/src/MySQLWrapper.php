<?php

/**
 * MySQLWrapper.php
 *
 * Access the sessions database
 *
 * Author: 18-3110-AP
 */

/**
 * Class MySQLWrapper
 */
class MySQLWrapper
{
  private $c_obj_db_handle;
  private $c_obj_sql_queries;
  private $c_obj_stmt;
  private $c_arr_errors;

    /**
     * MySQLWrapper constructor.
     */
  public function __construct()
  {
    $this->c_obj_db_handle = null;
    $this->c_obj_sql_queries = null;
    $this->c_obj_stmt = null;
    $this->c_arr_errors = [];
  }

    /**
     * MySQLWrapper destructor.
     */
  public function __destruct() { }

    /**
     * set database handle
     * @param $obj_db_handle new handle
     */
  public function set_db_handle($obj_db_handle)
  {
    $this->c_obj_db_handle = $obj_db_handle;
  }

    /**
     * executes query after checking it's safe
     * @param $query_string query to execute
     * @param null $arr_params optional parameters
     * @return mixed error message if applicable
     */
  public function safe_query($query_string, $arr_params = null)
  {
    $this->c_arr_errors['db_error'] = false;
    $query_string = $query_string;
    $arr_query_parameters = $arr_params;

    try
    {
      $temp = array();

      $this->c_obj_stmt = $this->c_obj_db_handle->prepare($query_string);

      if (sizeof($arr_query_parameters) > 0)
      {
        foreach ($arr_query_parameters as $param_key => $param_value)
        {
          $temp[$param_key] = $param_value;
          $this->c_obj_stmt->bindParam($param_key, $temp[$param_key], PDO::PARAM_STR);
        }
      }

      $execute_result = $this->c_obj_stmt->execute();
      $this->c_arr_errors['execute-OK'] = $execute_result;
    }
    catch (PDOException $exception_object)
    {
      $error_message  = 'PDO Exception caught. ';
      $error_message .= 'Error with the database access.' . "\n";
      $error_message .= 'SQL query: ' . $query_string . "\n";
      $error_message .= 'Error: ' . var_dump($this->c_obj_stmt->errorInfo(), true) . "\n";
      $this->c_arr_errors['db_error'] = true;
      $this->c_arr_errors['sql_error'] = $error_message;
    }
    return $this->c_arr_errors['db_error'];
  }

    /**
     * Gets number of rows
     * @return mixed number of rows
     */
  public function count_rows()
  {
    $num_rows = $this->c_obj_stmt->rowCount();
    return $num_rows;
  }

    /**
     * Gets number of rows using PDO:FETCH_NUM
     * @return mixed number of rows
     */
  public function safe_fetch_row()
  {
    $record_set = $this->c_obj_stmt->fetch(PDO::FETCH_NUM);
    return $record_set;
  }

    /**
     * safe fetches array using PDO::FETCH_ASSOC
     * @return mixed array from PDO database
     */
  public function safe_fetch_array()
  {
    $arr_row = $this->c_obj_stmt->fetch(PDO::FETCH_ASSOC);
    return $arr_row;
  }

    /**
     * Return the last used ID from the database
     * @return mixed last used ID
     */
  public function last_inserted_ID()
  {
    $sql_query = 'SELECT LAST_INSERT_ID()';

    $this->safe_query($sql_query);
    $arr_last_inserted_id = $this->safe_fetch_array();
    $last_inserted_id = $arr_last_inserted_id['LAST_INSERT_ID()'];
    return $last_inserted_id;
  }
}
