<?php

namespace App\Helpers;

class RegisterNumber {

    public static function execute(
        $registeredNumber, $subcode, $offset = 18, $zeroLn = 3
    ) : string {
        $num = $registeredNumber ? substr($registeredNumber, $offset)+1 : 1;
        return $subcode.ZeroOfNumber::execute(
            $num, $zeroLn
        );
    }
}
