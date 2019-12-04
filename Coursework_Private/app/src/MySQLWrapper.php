<?php

/**
 * MySQLWrapper.php
 *
 * Access the sessions database
 *
 * Author: CF Ingrams
 * Email: <clinton@cfing.co.uk>
 * Date: 22/10/2017
 *
 * @author CF Ingrams <clinton@cfing.co.uk>
 * @copyright CFI
 */

class MySQLWrapper
{
  private $c_obj_db_handle;
  private $c_obj_sql_queries;
  private $c_obj_stmt;
  private $c_arr_errors;

  public function __construct()
  {
    $this->c_obj_db_handle = null;
    $this->c_obj_sql_queries = null;
    $this->c_obj_stmt = null;
    $this->c_arr_errors = [];
  }

  public function __destruct() { }

  public function set_db_handle($obj_db_handle)
  {
    $this->c_obj_db_handle = $obj_db_handle;
  }

  public function safe_query($query_string, $arr_params = null)
  {
    $this->c_arr_errors['db_error'] = false;
    $query_string = $query_string;
    $arr_query_parameters = $arr_params;

    try
    {
      $temp = array();

      $this->c_obj_stmt = $this->c_obj_db_handle->prepare($query_string);

      // bind the parameters
      if (sizeof($arr_query_parameters) > 0)
      {
        foreach ($arr_query_parameters as $param_key => $param_value)
        {
          $temp[$param_key] = $param_value;
          $this->c_obj_stmt->bindParam($param_key, $temp[$param_key], PDO::PARAM_STR);
        }
      }

      // execute the query
      $execute_result = $this->c_obj_stmt->execute();
      $this->c_arr_errors['execute-OK'] = $execute_result;
    }
    catch (PDOException $exception_object)
    {
      $error_message  = 'PDO Exception caught. ';
      $error_message .= 'Error with the database access.' . "\n";
      $error_message .= 'SQL query: ' . $query_string . "\n";
      $error_message .= 'Error: ' . var_dump($this->c_obj_stmt->errorInfo(), true) . "\n";
      // NB would usually output to file for sysadmin attention
      $this->c_arr_errors['db_error'] = true;
      $this->c_arr_errors['sql_error'] = $error_message;
    }
    return $this->c_arr_errors['db_error'];
  }

  public function count_rows()
  {
    $num_rows = $this->c_obj_stmt->rowCount();
    return $num_rows;
  }

  public function safe_fetch_row()
  {
    $record_set = $this->c_obj_stmt->fetch(PDO::FETCH_NUM);
    return $record_set;
  }

  public function safe_fetch_array()
  {
    $arr_row = $this->c_obj_stmt->fetch(PDO::FETCH_ASSOC);
    return $arr_row;
  }

  public function last_inserted_ID()
  {
    $sql_query = 'SELECT LAST_INSERT_ID()';

    $this->safe_query($sql_query);
    $arr_last_inserted_id = $this->safe_fetch_array();
    $last_inserted_id = $arr_last_inserted_id['LAST_INSERT_ID()'];
    return $last_inserted_id;
  }
}
