<?php

namespace App\Helpers\Base;

use App\Interfaces\EnumContract;

abstract class BaseEnum implements EnumContract
{
    public static function getArray()
    {
        $result = [];
        foreach (static::getList() as $arr) {
            $result[$arr] = static::getString($arr);
        }
        return $result;
    }
}
