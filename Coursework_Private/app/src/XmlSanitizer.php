<?php

namespace Coursework;

/**
 * Class XmlSanitizer
 * @package Coursework
 */
class XmlSanitizer
{
    private $parsedXml;
    private $validator;

    /**
     * XmlSanitizer constructor.
     */
    public function __construct() {
        $this->validator = new \Coursework\Validator();
    }

    /**
     * XmlSanitizer destructor.
     */
    public function __destruct() { }

    /**
     * Sets parsed xml
     * @param $parsedXml parser xml data
     */
    public function setParsedXml($parsedXml){
        $this->parsedXml = $parsedXml;
    }

    /**
     * Gets parsed xml from class
     */
    public function getParsedXml(){
        return $this->parsedXml;
    }

    /**
     * Sanitizes the message data
     * @return mixed sanitized xml data
     */
    public function sanitizeMessageInput()
    {

        $this->sanitizeDate();
        $this->sanitizeBearer();
        $this->sanitizeSourcemsisdn();
        $this->sanitizeDestinationmsisdn();
        $this->sanitizeFan();
        $this->sanitizeHeater();
        $this->sanitizeKeypad();
        $this->sanitizeSwitch('s1');
        $this->sanitizeSwitch('s2');
        $this->sanitizeSwitch('s3');
        $this->sanitizeSwitch('s4');

        return $this->parsedXml;
    }

    /**
     * Sanitize date to correct format
     */
    public function sanitizeDate(){
        if(!$this->validator->validateDate($this->parsedXml->receivedtime)) {
            $this->parsedXml->receivedtime = null;
        } else {
            $date = date_parse_from_format('d/m/Y H:i:s',$this->parsedXml->receivedtime);
            $this->parsedXml->receivedtime = $date['year']. '/' .$date['month'] . '/' . $date['day']. ' ' . $date['hour'] . ':' . $date['minute']. ':' . $date['second'];
        }
    }

    /**
     * Sanitize bearer to correct format
     */
    public function sanitizeBearer(){
        if(!$this->validator->validateBearer((string) $this->parsedXml->bearer)) {
            $this->parsedXml->bearer = null;
        }
    }

    /**
     * Sanitize sourcemsidn to correct format
     */
    public function sanitizeSourcemsisdn(){
        if(!$this->validator->validateSourcemsisdn((int) $this->parsedXml->sourcemsisdn)) {
            $this->parsedXml->sourcemsisdn = null;
        }
    }

    /**
     * Sanitize destinationmsidn to correct format
     */
    public function sanitizeDestinationmsisdn(){
        if(!$this->validator->validateDestinationmsisdn((int) $this->parsedXml->destinationmsisdn)) {
            $this->parsedXml->destinationmsisdn = null;
        }
    }

    /**
     * Sanitize fan to correct format
     */
    public function sanitizeFan(){
        if(!$this->validator->validateFan($this->parsedXml->message->fan)) {
            $this->parsedXml->message->fan = null;
        }
    }

    /**
     * Sanitize heater to correct format
     */
    public function sanitizeHeater(){
        if(!$this->validator->validateHeater((string) $this->parsedXml->message->heater)) {
            $this->parsedXml->message->heater = null;
        }
    }

    /**
     * Sanitize keypad to correct format
     */
    public function sanitizeKeypad(){
        if(!$this->validator->validateKeypad((string) $this->parsedXml->message->keypad)) {
            $this->parsedXml->message->keypad = null;
        }
    }

    /**
     * Sanitize switch to correct format
     * @param $switchName which switch to sanitize
     */
    public function sanitizeSwitch($switchName){
        if(!$this->validator->validateSwitch($this->parsedXml->message->$switchName)) {
            $this->parsedXml->message->$switchName = null;
        }
    }
}