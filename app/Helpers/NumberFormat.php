<?php

namespace App\Helpers;

class NumberFormat {

    private static $thousandsSeparator = ',';

    private static $decimalSeparator = '.';

    private static $decimals = 2;

    public static function convert(
        $number,
        int $decimals = null,
    ) : string {
        return number_format(
            $number,
            $decimals,
            static::$decimalSeparator,
            static::$thousandsSeparator
        );
    }

    public static function isDecimal($number) : bool
    {
        return (float) $number !== floor($number);
    }

    public static function decimal($number)
    {
        return static::convert($number, static::$decimals);
    }

    public static function thousands($number)
    {
        return static::convert($number, 0);
    }

}
