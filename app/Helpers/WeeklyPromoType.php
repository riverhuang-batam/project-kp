<?php

namespace App\Helpers;

use App\Helpers\Base\BaseEnum;

class WeeklyPromoType extends BaseEnum
{
    const PERCENT_DISCOUNT = 1;
    const FIXED_DISCOUNT = 2;

    public static function getList()
    {
        return [
            self::PERCENT_DISCOUNT,
            self::FIXED_DISCOUNT,
        ];
    }

    public static function getString($val)
    {
        switch ($val) {
            case self::PERCENT_DISCOUNT:
                return "Percent discount";
            case self::FIXED_DISCOUNT:
                return "Fixed discount";
        }
    }
}
