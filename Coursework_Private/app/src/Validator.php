<?php
/**
 * Validator.php
 *
 *
 *
 * Author: 18-3110-AP
 */

namespace Coursework;

/**
 * Class Validator
 * @package Coursework
 */
class Validator
{
    /**
     * Validator constructor.
     */
    public function __construct() { }

    /**
     * Validator destructor.
     */
    public function __destruct() { }

    /**
     * Converts data type string to time
     * @param $value sata to change
     * @return false|int time from parameter or false for incorrect conversion
     */
    public function validateDate($value){
        return !!\DateTime::createFromFormat('d/m/Y H:i:s', $value);
    }

    /**
     * Validates bearer by checking data type string and string length
     * @param $value data to check
     * @return bool is data valid
     */
    public function validateBearer($value){
        return is_string($value) && strlen($value) < 10;
    }

    /**
     * Validate sourcemsidn by checking if numeric
     * @param $value data to check
     * @return bool is data valid
     */
    public function validateSourcemsisdn($value){
        return is_numeric($value);
    }

    /**
     * Validate destinationmsidn by checking if numeric
     * @param $value data to check
     * @return bool is data valid
     */
    public function validateDestinationmsisdn($value){
        return is_numeric($value);
    }

    /**
     * Validate fan by checking if its either 'forward' or 'reverse' string
     * @param $value data to check
     * @return bool is data valid
     */
    public function validateFan($value){
        return strtolower($value) == 'forward' || strtolower($value) == 'reverse';
    }

    /**
     * Validate heater by checking if numeric
     * @param $value data to check
     * @return bool is data valid
     */
    public function validateHeater($value){
        return is_numeric($value);
    }

    /**
     * Validate keypad by checking string length is 1 and is a number
     * @param $value data to check
     * @return bool is data valid
     */
    public function validateKeypad($value){
        return strlen($value) == 1 && is_numeric($value);
    }

    /**
     * Validate switch by checking if it's either string 'on' or 'off'
     * @param $value data to check
     * @return bool is data valid
     */
    public function validateSwitch($value){
        return strtolower($value) == 'on' || strtolower($value) == 'off';
    }

}