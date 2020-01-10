<?php
/**
 * @package stock-quotes
 */

namespace Coursework;

class RetrieveStockDataModel
{
    private $database_handle;
    private $soap_client_handle;
    private $downloaded_stockquote_data;
    private $database_connection_messages;
    private $stock_company_name_id;

    public function __construct()
    {
        $this->database_handle = null;
        $this->soap_client_handle = null;
        $this->downloaded_stockquote_data = array();
        $this->database_connection_messages = array();

        $this->stock_company_name_id = '';
    }

    public function __destruct(){}

    public function set_database_handle($p_obj_database_handle)
    {
        $this->database_handle = $p_obj_database_handle;
    }

    public function do_get_database_connection_result()
    {
        $this->database_connection_messages = $this->database_handle->get_connection_messages();
    }

    public function set_company_symbol($p_arr_sanitised_input)
    {
        $sanitised_company_symbol = '';
        if (isset($p_arr_sanitised_input['sanitised-$company_symbol']))
        {
            $sanitised_company_symbol = $p_arr_sanitised_input['sanitised-$company_symbol'];
        }
        $this->downloaded_stockquote_data['sanitised-$company_symbol'] = $sanitised_company_symbol;
    }

    public function do_download_stock_data()
    {
        $this->createSoapClient();
        $this->getStockquoteData();

        if ($this->downloaded_stockquote_data['soap-server-get-quote-result'])
        {
            $this->parseDownloadedStockquoteData();
            $this->checkStockDataAvailable();
        }
    }

    public function get_downloaded_stock_data_result()
    {
        return $this->downloaded_stockquote_data;
    }


    private function parseDownloadedStockquoteData()
    {
        $this->downloaded_stockquote_data['downloaded-company-data'] = StockQuoteContainer::make_sq_xml_parser_wrapper($this->downloaded_stockquote_data['raw-xml']);
    }

    private function checkStockDataAvailable()
    {
        $stock_data_available = true;
        if ($this->downloaded_stockquote_data['downloaded-company-data']['LAST'] == '0.00')
        {
            $stock_data_available = false;
        }
        $this->downloaded_stockquote_data['stock-data-available'] = $stock_data_available;
    }

    public function storeDownloadedStockData()
    {
        if ($this->downloaded_stockquote_data['soap-server-get-quote-result'])
        {
            if ($this->downloaded_stockquote_data['stock-data-available'])
            {
                $this->prepareStockData();
                if (!$this->doesCompanyExist())
                {
                    $this->storeNewCompanyDetails();
                }

                if (!$this->checkIfDataPreStored())
                {
                    $this->storeNewData();
                }
            }
        }
    }

    private function prepareStockData()
    {
        $database_connection_error = $this->database_connection_messages['database-connection-error'];

        if (!$database_connection_error)
        {
            $stock_date = $this->downloaded_stockquote_data['downloaded-company-data']['DATE'];
            $stock_time = $this->downloaded_stockquote_data['downloaded-company-data']['TIME'];

            $arr_date = explode('/', $stock_date);
            if (sizeof($arr_date) == 3)
            {
                $arr_prepared_quote_details['stock-date'] = $arr_date[2] . '-' . $arr_date[0] . '-' .$arr_date[1];
            }
            else
            {
                $arr_prepared_quote_details['stock-date'] = $stock_date;
            }

            $arr_time = explode(':', $stock_time);
            if (sizeof($arr_time) == 3)
            {
                $arr_prepared_quote_details['stock-time'] = $arr_time[0] . ':' . intval($arr_time[1]) . ':00';
            }
            else
            {
                $arr_prepared_quote_details['stock-time'] = $stock_time;
            }

            $this->downloaded_stockquote_data = array_merge($this->downloaded_stockquote_data, $arr_prepared_quote_details);
        }
    }

    // check if company is already in the database
    private function doesCompanyExist()
    {
        $sql_query_string = StockQuoteSqlQuery::check_company_symbol();
        $arr_sql_query_parameters = array(':stock_company_symbol' => $this->downloaded_stockquote_data['sanitised-$company_symbol']);

        $this->database_handle->safe_query($sql_query_string, $arr_sql_query_parameters);

        $number_of_rows = $this->database_handle->count_rows();

        $stock_company_exists = false;
        if ($number_of_rows > 0)
        {
            $stock_company_exists = true;
            $row = $this->database_handle->safe_fetch_array();
            $this->stock_company_name_id = $row['stock_company_name_id'];
        }

        return $stock_company_exists;
    }

    private function storeNewCompanyDetails()
    {
        $stock_symbol = $this->downloaded_stockquote_data['downloaded-company-data']['SYMBOL'];
        $stock_company_name = $this->downloaded_stockquote_data['downloaded-company-data']['NAME'];

        // add the new company's details
        $sql_query_string = StockQuoteSqlQuery::store_company_name();

        $arr_sql_query_parameters =
            array(':stock_company_symbol' => $stock_symbol,
                ':stock_company_name' => $stock_company_name);

        $arr_database_execution_messages = $this->database_handle->safe_query($sql_query_string, $arr_sql_query_parameters);

        if ($arr_database_execution_messages['execute-OK'])
        {
            $stock_company_name_stored = true;
            $this->stock_company_name_id = $this->database_handle->last_inserted_id();
        }
        else
        {
            $stock_company_name_stored = false;
        }
        $this->downloaded_stockquote_data['company-details-stored'] = $stock_company_name_stored;
    }

    // check to see if the data values exist in the stock values database table
    private function checkIfDataPreStored()
    {
        $this->reformatTimeString();
        $stock_symbol = $this->downloaded_stockquote_data['downloaded-company-data']['SYMBOL'];
        $stock_date = $this->downloaded_stockquote_data['stock-date'];
        $stock_time = $this->downloaded_stockquote_data['stock-time'];

        $sql_query_string = StockQuoteSqlQuery::does_company_exist();

        $arr_sql_query_parameters =
            array(':stock_company_symbol' => $stock_symbol,
                ':stock_date' => $stock_date,
                ':stock_time' => $stock_time);

        $this->database_handle->safe_query($sql_query_string, $arr_sql_query_parameters);

        $number_of_rows = $this->database_handle->count_rows();
        $stock_data_exists = false;
        if ($number_of_rows > 0)
        {
            $stock_data_exists = true;
        }
        return $stock_data_exists;
    }

    private function storeNewData()
    {
        $stock_date = $this->downloaded_stockquote_data['stock-date'];
        $stock_time = $this->downloaded_stockquote_data['stock-time'];
        $stock_last_value = $this->downloaded_stockquote_data['downloaded-company-data']['LAST'];
        $stock_company_name_id = $this->stock_company_name_id;

        $sql_query_string = StockQuoteSqlQuery::store_stock_data();

        $arr_sql_query_parameters =
            [':stock_date' => $stock_date,
                ':stock_time' => $stock_time,
                ':stock_last_value' => $stock_last_value,
                ':fk_company_stock_id' => $stock_company_name_id
            ];


        $arr_database_execution_messages = $this->database_handle->safe_query($sql_query_string, $arr_sql_query_parameters);
        $new_stock_data_stored = false;

        if ($arr_database_execution_messages['execute-OK'])
        {
            $new_stock_data_stored = true;
        }
        $this->downloaded_stockquote_data['stock-details-stored']= $new_stock_data_stored;
    }

    /** example of web service API update
     * time now has am/pm appended
     * so these now have to be stripped out
     * so that the database will accept this data
     */
    private function reformatTimeString()
    {
        $stock_time = $this->downloaded_stockquote_data['stock-time'];
        $stock_time = str_replace('am', '', $stock_time);
        $stock_time = str_replace('pm', '', $stock_time);
        $this->downloaded_stockquote_data['stock-time'] = $stock_time;
    }
}
