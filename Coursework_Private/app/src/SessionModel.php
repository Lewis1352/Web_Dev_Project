<?php
/**
 * SessionModel.php
 *
 * stores the validated values in the relevant storage location
 *
 * Author: 18-3110-AP
 */

/**
 * Class SessionModel
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

    /**
     * SessionModel constructor.
     */
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

    /**
     * SessionModel destructor.
     */
  public function __destruct() { }

    /**
     * Set session username and password
     * @param $username username for session
     * @param $password password for session
     */
  public function set_session_values($username, $password)
  {
    $this->c_username = $username;
    $this->c_password = $password;
  }

    /**
     * Set server type
     * @param $server_type new type of server
     */
  public function set_server_type($server_type)
  {
    $this->c_server_type = $server_type;
  }

    /**
     * Set wrapper session
     * @param $obj_wrapper_session new wrapper session
     */
  public function set_wrapper_session_file($obj_wrapper_session)
  {
    $this->c_obj_wrapper_session_file = $obj_wrapper_session;
  }

    /**
     * Set wrapper session of database
     * @param $obj_wrapper_db new database wrapper session
     */
  public function set_wrapper_session_db($obj_wrapper_db)
  {
    $this->c_obj_wrapper_session_db = $obj_wrapper_db;
  }

    /**
     * Set database handler
     * @param $obj_db_handle new database handler
     */
  public function set_db_handle($obj_db_handle)
  {
    $this->c_obj_db_handle = $obj_db_handle;
  }

    /**
     * Set sql queries
     * @param $obj_sql_queries new sql queries
     */
  public function set_sql_queries($obj_sql_queries)
  {
    $this->c_obj_sql_queries = $obj_sql_queries;
  }

    /**
     * Store database in database or file session depending on server type
     */
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

    /**
     * Get storage result
     * @return null result of storage
     */
  public function get_storage_result()
  {
    return $this->c_arr_storage_result;
  }

    /**
     * Store data in a session file
     * @return bool Storage result
     */
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

    /**
     * Store data in database session
     * @return bool Storage result
     */
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
