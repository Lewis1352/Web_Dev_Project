<?php

/**
 * SQLQueries.php
 *
 * hosts all SQL queries to be used by the Model
 *
 * Author: 18-3110-AP
 */

namespace Coursework;

/**
 * Class SQLQueries
 * @package Coursework
 */
class SQLQueries
{
    /**
     * SQLQueries constructor.
     */
    public function __construct() { }

    /**
     * SQLQueries destructor.
     */
    public function __destruct() { }

    /**
     * Get message data from database query
     * @return string sql query for get messages
     */
    public function getMessageData()
    {
        $query_string  = "SELECT * ";
        $query_string .= "FROM messages ";
        $query_string .= "ORDER BY received_date DESC";
        return $query_string;
    }

    /**
     * Store message data into database query
     * @return string sql query for store messages
     */
    public function storeMessageData()
    {
        $query_string  = "INSERT INTO messages ";
        $query_string .= "SET ";
        $query_string .= "received_date = :message_received_date,";
        $query_string .= "soursemsisdn = :message_soursemsisdn, ";
        $query_string .= "destinationmsisdn = :message_destinationmsisdn, ";
        $query_string .= "bearer = :message_bearer,";
        $query_string .= "fan = :message_fan, ";
        $query_string .= "keypad = :message_keypad, ";
        $query_string .= "heater = :message_heater, ";
        $query_string .= "switch_1 = :message_switch_1, ";
        $query_string .= "switch_2 = :message_switch_2, ";
        $query_string .= "switch_3 = :message_switch_3, ";
        $query_string .= "switch_4 = :message_switch_4 ";
        return $query_string;
    }

    /**
     * Check message data from database sql query
     * @return string sql query for checking message data
     */
    public function checkMessageData()
    {
        $query_string  = "Select id ";
        $query_string .= "FROM messages ";
        $query_string .= "WHERE ";
        $query_string .= "received_date = :message_received_date AND ";
        $query_string .= "soursemsisdn = :message_soursemsisdn AND ";
        $query_string .= "destinationmsisdn = :message_destinationmsisdn AND ";
        $query_string .= "bearer = :message_bearer AND ";
        $query_string .= "fan = :message_fan AND ";
        $query_string .= "keypad = :message_keypad AND ";
        $query_string .= "heater = :message_heater AND ";
        $query_string .= "switch_1 = :message_switch_1 AND ";
        $query_string .= "switch_2 = :message_switch_2 AND ";
        $query_string .= "switch_3 = :message_switch_3 AND ";
        $query_string .= "switch_4 = :message_switch_4";
        return $query_string;
    }

}
