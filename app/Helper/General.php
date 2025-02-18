<?php

namespace App\Helper;

class General
{
    public static function generateAttendanceCode($key)
    {
        $hash = md5($key);
        $code = substr(preg_replace('/[^0-9]/', '', $hash), 0, 10);
        return $code;
    }

    
}
