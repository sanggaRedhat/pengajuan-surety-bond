<?php

namespace App\Helpers;

class ZeroOfNumber {

    public static function execute(
        $number, $zeroLn
    ) : string {
        $zero = '';
        for ($i=strlen($number); $i < $zeroLn; $i++) {
            $zero .= '0';
        }
        return $zero.$number;
    }

}
