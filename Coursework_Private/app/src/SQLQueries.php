<?php

/**
 * SQLQueries.php
 *
 * hosts all SQL queries to be used by the Model
 *
 * Author: CF Ingrams
 * Email: <clinton@cfing.co.uk>
 * Date: 22/10/2017
 *
 * @author CF Ingrams <clinton@cfing.co.uk>
 * @copyright CFI
 */

namespace Coursework;

class SQLQueries
{
    public function __construct() { }

    public function __destruct() { }

    public function getAllCompanySymbols()
    {
        $query_string  = "SELECT stock_company_symbol, stock_company_name ";
        $query_string .= "FROM company_name ";
        $query_string .= "ORDER BY stock_company_name";
        return $query_string;
    }

    public function getMessageData()
    {
        $query_string  = "SELECT * ";
        $query_string .= "FROM messages ";
        $query_string .= "ORDER BY received_date";
        return $query_string;
    }
    public function checkCompanySymbol()
    {
        $query_string  = "SELECT stock_company_symbol, stock_company_name_id ";
        $query_string .= "FROM sq_company_name ";
        $query_string .= "WHERE stock_company_symbol = :stock_company_symbol ";
        $query_string .= "LIMIT 1";
        return $query_string;
    }

    public function storeCompanyName()
    {
        $query_string  = "INSERT INTO sq_company_name ";
        $query_string .= "SET ";
        $query_string .= "stock_company_symbol = :stock_company_symbol, ";
        $query_string .= "stock_company_name = :stock_company_name;";
        return $query_string;
    }

    public function getCompanyDetails()
    {
        $query_string  = "SELECT stock_company_name_id, stock_company_symbol, stock_company_name ";
        $query_string .= "FROM sq_company_name;";
        return $query_string;
    }

    public function checkCompanyExists()
    {
        $query_string  = "SELECT stock_company_name_id ";
        $query_string .= "FROM sq_company_name, sq_stock_data ";
        $query_string .= "WHERE sq_company_name.stock_company_symbol = :stock_company_symbol ";
        $query_string .= "AND sq_company_name.stock_company_name_id = sq_stock_data.fk_company_stock_id ";
        $query_string .= "AND stock_date = :stock_date ";
        $query_string .= "AND stock_time = :stock_time ";
        $query_string .= "LIMIT 1";
        return $query_string;
    }

    public function storeMessageData()
    {
        $query_string  = "INSERT INTO messages ";
        $query_string .= "SET ";
        $query_string .= "content = :message_content, ";
        $query_string .= "received_date = :message_received_date";
        return $query_string;
    }

    public static function storeErrorMessage()
    {
        $query_string  = "INSERT INTO sq_error_log ";
        $query_string .= "SET ";
        $query_string .= "log_message = :logmessage";
        return $query_string;
    }
}
