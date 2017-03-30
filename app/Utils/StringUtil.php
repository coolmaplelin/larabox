<?php

namespace App\Utils;

class StringUtil
{

    public static function parseEmails($emailString)
    {
        $emails = $emailString;
        $delimiterArray = array("\r\n", "\n\r", "\n", "\t", ";" , "," , "    " ,"   ", "  ");
        foreach($delimiterArray as $da){
            $emails = str_replace($da, " ", trim($emails));
        }
        $emails = str_replace("
", " ", $emails);
        return explode(" ", $emails);
    }
}
