<?php
/**
 * MessageModel.php
 *
 *
 *
 * Author: 18-3110-AP
 */

namespace Coursework;

/**
 * Class MessageModel
 * @package Coursework
 */
class MessageModel
{
    private $database_wrapper;
    private $database_connection_settings;
    private $sql_queries;
    private $sanitizer;

    /**
     * MessageModel constructor.
     */
    public function __construct(){}

    /**
     * MessageModel destructor.
     */
    public function __destruct(){}

    /**
     * Sets the database wrapper
     * @param $database_wrapper database wrapper
     */
    public function setDatabaseWrapper($database_wrapper)
    {
        $this->database_wrapper = $database_wrapper;
    }

    /**
     * Set the database settings
     * @param $database_connection_settings new settings
     */
    public function setDatabaseConnectionSettings($database_connection_settings)
    {
        $this->database_connection_settings = $database_connection_settings;
    }

    /**
     * Sets the sql queries
     * @param $sql_queries new queries
     */
    public function setSqlQueries($sql_queries)
    {
        $this->sql_queries = $sql_queries;
    }

    /**
     * set the sanitizer
     * @param $sanitizer new sanitizer
     */
    public function setSanitizer($sanitizer){
        $this->sanitizer = $sanitizer;
    }

    /**
     * Gets the messages data from database
     *
     * Gets the data from the database, counts the rows of data
     * For each row assigns tags from message to the message data variable
     *
     * @return array message split up by tags
     */
    public function getMessageData()
    {
        $messages = [];
        $message_id = '';
        $message_data = [];

        $query_string = $this->sql_queries->getMessageData();

        $this->setupDatabaseConnection();

        $this->database_wrapper->safeQuery($query_string);

        $number_of_data_sets = $this->database_wrapper->countRows();

        if ($number_of_data_sets > 0)
        {
            $lcv = 0;
            while ($row = $this->database_wrapper->safeFetchArray())
            {
                $message_id = $row['id'];
                $message_data[$lcv]['received_date'] = $row['received_date'];
                $message_data[$lcv]['soursemsisdn'] = $row['soursemsisdn'];
                $message_data[$lcv]['destinationmsisdn'] = $row['destinationmsisdn'];
                $message_data[$lcv]['bearer'] = $row['bearer'];
                $message_data[$lcv]['switch_1'] = $row['switch_1'];
                $message_data[$lcv]['switch_2'] = $row['switch_2'];
                $message_data[$lcv]['switch_3'] = $row['switch_3'];
                $message_data[$lcv]['switch_4'] = $row['switch_4'];
                $message_data[$lcv]['fan'] = $row['fan'];
                $message_data[$lcv]['heater'] = $row['heater'];
                $message_data[$lcv]['keypad'] = $row['keypad'];

                $lcv++;
            }
        }
        else
        {
            $messages[0] = 'No messages found';
        }

        $messages['id'] = $message_id;
        $messages['message-data-sets'] = $number_of_data_sets;
        $messages['message_data'] = $message_data;

        return $messages;
    }

    /**
     * Stores messagesContent parameter to the database
     * @param $messageContent data to store to the database
     */
    public function storeMessageData($messageContent){
        $this->sanitizer->setParsedXml($messageContent);
        $messageContent = $this->sanitizer->sanitizeMessageInput();

        if(!$this->messageDuplicate($messageContent)){
            $query_string = $this->sql_queries->storeMessageData();

            $query_parameters = $this->getMessageTableQueryParameters($messageContent);

            $this->setupDatabaseConnection();

            $this->database_wrapper->safeQuery($query_string, $query_parameters);
        }
    }

    /**
     * begins database connection
     */
    private function setupDatabaseConnection(){
        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);

        $this->database_wrapper->makeDatabaseConnection();
    }

    /**
     * Checks messageContent against database for duplicates
     * @param $messageContent data to compare with the database
     * @return bool if there is a duplicate
     */
    private function messageDuplicate($messageContent){
        $query_string = $this->sql_queries->checkMessageData();

        $query_parameters = $this->getMessageTableQueryParameters($messageContent);

        $this->setupDatabaseConnection();

        $this->database_wrapper->safeQuery($query_string, $query_parameters);

        return $this->database_wrapper->countRows() > 0;
    }

    /**
     * Gets the sql query parameters
     * @param $messageContent message data to get parameters from
     * @return array query parameters
     */
    private function getMessageTableQueryParameters($messageContent){
        return [
            ':message_received_date' => $messageContent->receivedtime,
            ':message_bearer' => $messageContent->bearer,
            ':message_soursemsisdn' => $messageContent->sourcemsisdn,
            ':message_destinationmsisdn' => $messageContent->destinationmsisdn,
            ':message_fan' => $messageContent->message->fan,
            ':message_heater' => $messageContent->message->heater,
            ':message_keypad' => $messageContent->message->keypad,
            ':message_switch_1' => $messageContent->message->s1,
            ':message_switch_2' => $messageContent->message->s2,
            ':message_switch_3' => $messageContent->message->s3,
            ':message_switch_4' => $messageContent->message->s4,
        ];
    }

}