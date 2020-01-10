<?php

namespace Coursework;

class soapWrapper
{

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

    public function getSoapData()
    {
        $soap_server_get_quote_result = null;
        $stock_quote_data = null;
        $raw_xml = '';

        if ($this->soap_client_handle)
        {
            try
            {
                $stock_quote_data = $this->getQuote();

                $raw_xml = $stock_quote_data->GetQuoteResult;
                if (strcmp($raw_xml, 'exception') == 0)
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
        $this->downloaded_stockquote_data['raw-xml'] = $raw_xml;
        $this->downloaded_stockquote_data['soap-server-get-quote-result'] = $soap_server_get_quote_result;
    }


}