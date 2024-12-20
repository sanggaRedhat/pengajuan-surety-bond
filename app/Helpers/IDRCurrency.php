<?php

namespace App\Helpers;

class IDRCurrency {

    public static function convert(
        int $number,
        ?bool $isEnd = false,
    ) : string {
        return 'Rp. '
            .NumberFormat::thousands($number)
            .(!$isEnd ? '' : ',-');
    }

    public static function convertToInt(
        string $currency,
    ) : int {
        return str_replace(['Rp. ', ',', '-'], '', $currency);
    }

}
