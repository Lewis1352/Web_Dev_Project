<?php

use Coursework\XmlSanitizer;
use PHPUnit\Framework\TestCase;

class XmlSanitizerTests extends TestCase
{
    public function testValidateReturnsTrueIfXmlParseIsCorrect()
    {
        $xmlSanitizer = new XmlSanitizer;

        $xml = '<messagerx><sourcemsisdn>447817814149</sourcemsisdn><destinationmsisdn>447817814149</destinationmsisdn><receivedtime>13/01/2020 09:30:21</receivedtime><bearer>SMS</bearer><messageref>0</messageref><message><s1>on</s1><s2>on</s2><s3>on</s3><s4>on</s4><heater>4</heater><fan>forward</fan><keypad>1</keypad><id>18-3110-AP</id></message></messagerx>';
        $parsedXml = simplexml_load_string($xml);
        $xmlSanitizer->setParsedXml($parsedXml);

        $this->assertEquals($xmlSanitizer->getParsedXml(), $parsedXml);
    }

    public function testValidateReturnsFalseIfXmlParseIsNotCorrect()
    {
        $xmlSanitizer = new XmlSanitizer;

        $xml = '<messagerx><sourcemsisdn>447817814149</sourcemsisdn><destinationmsisdn>447817814149</destinationmsisdn><receivedtime>13/01/2020 09:30:21</receivedtime><bearer>SMS</bearer><messageref>0</messageref><message><s1>on</s1><s2>on</s2><s3>on</s3><s4>on</s4><heater>4</heater><fan>forward</fan><keypad>1</keypad><id>18-3110-AP</id></message></messagerx>';
        $parsedXml = simplexml_load_string($xml);
        $xmlSanitizer->setParsedXml($parsedXml);

        $this->assertNotEquals($xmlSanitizer->getParsedXml(), 'test');
    }

    public function testValidateReturnsFalseIfSwtich()
    {
        $xmlSanitizer = new XmlSanitizer;

        $xml = '<messagerx><sourcemsisdn>447817814149</sourcemsisdn><destinationmsisdn>447817814149</destinationmsisdn><receivedtime>13/01/2020 09:30:21</receivedtime><bearer>SMS</bearer><messageref>0</messageref><message><s1>on</s1><s2>on</s2><s3>on</s3><s4>test</s4><heater>4</heater><fan>forward</fan><keypad>1</keypad><id>18-3110-AP</id></message></messagerx>';
        $parsedXml = simplexml_load_string($xml);
        $xmlSanitizer->setParsedXml($parsedXml);

        $this->assertFalse($xmlSanitizer->sanitizeSwitch('s4'));
    }

}