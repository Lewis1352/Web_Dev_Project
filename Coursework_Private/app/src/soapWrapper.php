<?php
/**
 * soapWrapper.php
 *
 * handles the soap client
 *
 * Author: 18-3110-AP
 */

namespace Coursework;

/**
 * Class soapWrapper
 * @package Coursework
 */
class soapWrapper
{

    /**
     * Creates the soap client
     * @return \SoapClient handle for the soap client
     */
    public function createSoapClient()
    {
        $soap_server_connection_result = null;
        $arr_soapclient = array();

        $wsdl = WSDL;

        $arr_soapclient = array('trace' => true, 'exceptions' => true);

        try
        {
            $this->soap_client_handle = new \SoapClient($wsdl, $arr_soapclient);
            $soap_server_connection_result = true;
        }
        catch (SoapFault $obj_exception)
        {
            $soap_server_connection_result = false;
        }

        $this->downloaded_message_data['soap-server-connection-result'] = $soap_server_connection_result;

        return $this->soap_client_handle;
    }


    /**
     * Gets data from the soap client
     * @param $soap_call_parameters parameters for soap client
     */
    public function getSoapData($soap_call_parameters)

    {
        $soap_server_get_quote_result = null;
        $stock_quote_data = null;
        $raw_xml = '';

        if ($this->soap_client_handle)
        {
            try
            {
                $message_data = $this->soap_client_handle->__soapcall('peekMessages',$soap_call_parameters);
                $raw_xml = $message_data;
                if (is_array($raw_xml))
                {
                    $soap_server_get_quote_result = false;
                }
                else
                {
                    $soap_server_get_quote_result = true;
                }
            }
            catch (SoapFault $obj_exception)
            {
                $soap_server_get_quote_result = $obj_exception;
            }
        }
        $this->downloaded_message_data['raw-xml'] = $raw_xml;
        $this->downloaded_message_data['soap-server-get-quote-result'] = $soap_server_get_quote_result;
    }

    public function sendSMS($soap_call_parameters){

        $soap_server_get_quote_result = null;
        $stock_quote_data = null;
        $raw_xml = '';

        if ($this->soap_client_handle)
        {
            try
            {
                $this->soap_client_handle->__soapcall('sendMessage',$soap_call_parameters);
            }
            catch (SoapFault $obj_exception)
            {

            }
        }
    }


}