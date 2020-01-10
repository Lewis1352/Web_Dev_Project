<?php

namespace Coursework;

class Validator
{
    public function __construct() { }

    public function __destruct() { }

    public function validateCompanySymbol($tainted_company_symbol)
    {
        $validated_company_symbol = false;
        $permitted_symbol_length = 3;

        if (!empty($tainted_company_symbol))
        {
            $sanitised_company_symbol = filter_var($tainted_company_symbol, FILTER_SANITIZE_STRING);
            $symbol_length = strlen($sanitised_company_symbol);

            if ($symbol_length == $permitted_symbol_length)
            {
                $validated_company_symbol = $sanitised_company_symbol;
            }
            else
            {
                $validated_company_symbol = 'Invalid company symbol';
            }
        }
    else
        {
            $validated_company_symbol = 'None selected';
        }
        return $validated_company_symbol;
    }
}