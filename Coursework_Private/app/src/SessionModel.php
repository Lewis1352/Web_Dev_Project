<?php
/**
 * SessionModel.php
 *
 * stores the validated values in the relevant storage location
 *
 * Author: CF Ingrams
 * Email: <clinton@cfing.co.uk>
 * Date: 22/10/2017
 *
 *
 * @author CF Ingrams <clinton@cfing.co.uk>
 * @copyright CFI
 *
 */

class SessionModel
{
  private $c_username;
  private $c_server_type;
  private $c_password;
  private $c_arr_storage_result;
  private $c_obj_wrapper_session_file;
  private $c_obj_wrapper_session_db;
  private $c_obj_db_handle;
  private $c_obj_sql_queries;

  public function __construct()
  {
    $this->c_username = null;
    $this->c_server_type = null;
    $this->c_password = null;
    $this->c_arr_storage_result = null;
    $this->c_obj_wrapper_session_file = null;
    $this->c_obj_wrapper_session_db = null;
    $this->c_obj_db_handle = null;
    $this->c_obj_sql_queries = null;
  }

  public function __destruct() { }

  public function set_session_values($username, $password)
  {
    $this->c_username = $username;
    $this->c_password = $password;
  }

  public function set_server_type($server_type)
  {
    $this->c_server_type = $server_type;
  }

  public function set_wrapper_session_file($obj_wrapper_session)
  {
    $this->c_obj_wrapper_session_file = $obj_wrapper_session;
  }

  public function set_wrapper_session_db($obj_wrapper_db)
  {
    $this->c_obj_wrapper_session_db = $obj_wrapper_db;
  }

  public function set_db_handle($obj_db_handle)
  {
    $this->c_obj_db_handle = $obj_db_handle;
  }

  public function set_sql_queries($obj_sql_queries)
  {
    $this->c_obj_sql_queries = $obj_sql_queries;
  }

  public function store_data()
  {
    switch ($this->c_server_type)	{
      case 'database':
        $this->c_arr_storage_result['database'] = $this->store_data_in_database();
        break;
      case 'file':
      default:
        $this->c_arr_storage_result['file'] = $this->store_data_in_session_file();
    }
  }

  public function get_storage_result()
  {
    return $this->c_arr_storage_result;
  }

  private function store_data_in_session_file()
  {
    $store_result = false;
    $store_result_username = $this->c_obj_wrapper_session_file->set_session('user_name', $this->c_username);
    $store_result_password = $this->c_obj_wrapper_session_file->set_session('password', $this->c_password);

    if ($store_result_username !== false && $store_result_password !== false)	{
      $store_result = true;
    }
    return $store_result;
  }

  public function store_data_in_database()
  {
    $store_result = false;

    $this->c_obj_wrapper_session_db->set_db_handle( $this->c_obj_db_handle);
    $this->c_obj_wrapper_session_db->set_sql_queries( $this->c_obj_sql_queries);

    $store_result = $this->c_obj_wrapper_session_db->store_session_var('user_name', $this->c_username);
    $store_result = $this->c_obj_wrapper_session_db->store_session_var('user_password', $this->c_password);

    return $store_result;
  }
}
