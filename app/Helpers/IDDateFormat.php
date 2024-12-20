<?php

namespace App\Helpers;

use Carbon\Carbon;

class IDDateFormat
{

    const DAYS = [
        'Sunday'    => 'Minggu',
        'Monday'    => 'Senin',
        'Tuesday'   => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday'  => 'Kamis',
        'Friday'    => 'Jumat',
        'Saturday'  => 'Sabtu'
    ];

    const MONTHS = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];

    const SHORT_MONTHS = [
        1 => 'Jan',
        'Feb',
        'Mar',
        'Apr',
        'Mei',
        'Jun',
        'Jul',
        'Agu',
        'Sep',
        'Okt',
        'Nov',
        'Des',
    ];

    public static function convert($date, $fomatText = false, $short = false)
    {
        $dateConvert = Carbon::parse($date)->format('d-m-Y');

        if ($fomatText) {
            $exp = explode('-', $dateConvert);

            $month = $short
                ? static::SHORT_MONTHS[(int)$exp[1]]
                : static::MONTHS[(int)$exp[1]];

            return $exp[0].' '.$month.' '.$exp[2];
        }

        return $dateConvert;
    }

    public static function day($date)
    {
        return static::DAYS[Carbon::parse($date)->format('l')];
    }

    public static function dayDate($date, $fomatText = true)
    {
        return static::day($date).', '.static::convert($date, $fomatText);
    }

    public static function month($date)
    {
        return static::MONTHS[(int) Carbon::parse($date)->format('m')];
    }

    public static function monthDate($date)
    {
        return static::month($date).' '.static::year($date);
    }

    public static function year($date, $format = 'Y')
    {
        return Carbon::parse($date)->format($format);
    }

}
